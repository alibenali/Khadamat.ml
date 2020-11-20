<?php

namespace App\Http\Controllers\Voyager;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Database\Schema\Schemaserverr;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataRestored;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

use App\Balance;
use App\Payment;
use App\Service;
use App\Payments_offer;
use App\Conversation;
use App\Message;
use App\BalanceHistory;
use Auth;
use App\user;
use App\Http\Requests\paymentRequest;
use App\Http\Requests\acceptPaymentRequest;
use App\Traits\createNotification;
use App\Traits\balanceTrait;

class PaymentController extends VoyagerBaseController
{
    use BreadRelationshipParser;

    use createNotification;
    use balanceTrait;


    //***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      Browse our Data Type (B)READ
    //
    //****************************************

    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];
        $searchable = $dataType->server_side ? array_keys(Schemaserverr::describeTable(app($dataType->model_name)->getTable())->toArray()) : '';
        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', null);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;
        $orderColumn = [];
        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + 1;
            $orderColumn = [[$index, 'desc']];
            if (!$sortOrder && isset($dataType->order_direction)) {
                $sortOrder = $dataType->order_direction;
                $orderColumn = [[$index, $dataType->order_direction]];
            } else {
                $orderColumn = [[$index, 'desc']];
            }
        }

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
                $query = $model->{$dataType->scope}();
            } else {
                $query = $model::select('*');
            }

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses($model)) && app('VoyagerAuth')->user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }
            }


            if (Auth::user()->hasRole('user')){
				 $query = $query->where('creator_id', Auth::id());
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
                $query->where($search->key, $search_filter, $search_value);
            }

            if ($orderBy && in_array($orderBy, $dataType->fields())) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        if (($isModelTranslatable = is_bread_translatable($model))) {
            $dataTypeContent->load('translations');
        }

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        // Check if a default search key is set
        $defaultSearchKey = $dataType->default_search_key ?? null;

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortOrder',
            'searchable',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted'
        ));
    }


    public function pending(acceptPaymentRequest $request){


        $payment_id = $request->input('payment_id');
        $payment = Payment::find($payment_id);
        $this->authorize('pending', $payment);

        $conversation = Conversation::where('payment_id', $payment->id)->first();


        $payment->the_status = "pending";
        $conversation->the_status = "pending";
        $conversation->save();
        $payment->save();

        // Create new mesasge
        $message = new Message;
        $message->user_id = 0;
        $message->the_type = "controller";
        $message->conversation_id = $conversation->id;
        $message->content = "paymentPending";
        $message->save();

        $this->createNotification($conversation->user_id,'paymentPending','',url('conversation/'.$conversation->id));

        return redirect('server/conversation/'.$conversation->id.'');
    }

    public function accept(acceptPaymentRequest $request){


        $payment_id = $request->input('payment_id');
        $payment = Payment::find($payment_id);
        $service = Service::find($payment->service_id);
        $conversation = Conversation::where('payment_id', $payment->id)->first();


        $this->authorize('accept', $payment);

        $payments_offer = Payments_offer::where('payment_id',$payment_id)->where('the_status', 'paid')->get();

        foreach($payments_offer as $offer){

        $this->balanceDown($offer->user_id, 'hold_'.$offer->pm_slug, $offer->price, "Payment accpeted (offer ".$offer->id.")", "coversation/".$payment->id);
        }

        $payment_method = strtolower($payment->payment_method.'_'.$payment->currency);
        $hold_p_method = strtolower('hold_'.$payment_method);
        $balance_amount = $payment->total;


        $payment->the_status = "accepted";
        $conversation->the_status = "accepted";
        $conversation->save();
        $payment->save();

        //Update quantity
        $service->remaining = $service->remaining - $payment->quantity;
        $service->purchases_number = $service->purchases_number + 1;
        $service->save();

        // Create new mesasge
        $message = new Message;
        $message->user_id = 0;
        $message->the_type = "controller";
        $message->conversation_id = $conversation->id;
        $message->content = "paymentAccepted";
        $message->save();

        // Create new mesasge
        $message = new Message;
        $message->user_id = 0;
        $message->conversation_id = $conversation->id;
        $message->the_type = "rating";
        $message->content = "rating";
        $message->save();

        $this->createNotification($conversation->user_id,'paymentCompleted','',url('conversation/'.$conversation->id));
        $this->balanceDown($payment->user_id, $hold_p_method, $balance_amount, "Payment accpeted", "coversation/".$payment->id);
        
        return redirect('server/conversation/'.$conversation->id.'');
    }


    public function pay(acceptPaymentRequest $request){


        $payment_id = $request->input('payment_id');
        $payment = Payment::find($payment_id);
        $this->authorize('pay', $payment);

        $payments_offer = Payments_offer::where('payment_id',$payment_id)->where('the_status', 'paid')->get();

        foreach($payments_offer as $offer){
            $payment_method = $offer->pm_slug;
            $balance_amount = $offer->price;
            $this->balanceUp($payment->creator_id, $payment_method, $balance_amount, "Payment paid (offer ".$offer->id.")", "coversation/".$payment->id);
        }
        
        $payment_method = strtolower($payment->payment_method.'_'.$payment->currency);
        $hold_p_method = strtolower('hold_'.$payment_method);

        $balance_amount = $payment->price * $payment->quantity;

        $payment->server_status = "paid";
        $payment->save();

        $this->createNotification($payment->creator_id,'paymentPaid','',url('server/earning/'));
        $this->balanceUp($payment->creator_id, $payment_method, $balance_amount, "Payment paid (offer ".$offer->id.")", "coversation/".$payment->id);

        return redirect('server/payments');
    }


    public function refuse(acceptPaymentRequest $request){


        $payment_id = $request->input('payment_id');
        $raison = $request->input('raison');
        $payment = Payment::find($payment_id);
        $this->authorize('refuse', $payment);

        $payments_offer = Payments_offer::where('payment_id',$payment_id)->where('the_status', 'paid')->get();
        $balance = Balance::where('user_id', $payment->user_id)->first();

        foreach($payments_offer as $offer){
            $payment_method = $offer->pm_slug;
            $hold_payment_method = 'hold_'.$payment_method;
            $balance_amount = $offer->price;


            $this->balanceUp($payment->user_id, $payment_method, $balance_amount, "Payment refused (offer ".$offer->id.")", "coversation/".$payment->id);
            $this->balanceDown($payment->user_id, $hold_payment_method, $balance_amount, "Payment refused (offer ".$offer->id.")", "coversation/".$payment->id);


        }

        $conversation = Conversation::where('payment_id', $payment->id)->first();

        $payment_method = strtolower($payment->payment_method.'_'.$payment->currency);
        $hold_p_method = strtolower('hold_'.$payment_method);
        $balance_amount = $payment->total;

        $this->balanceDown($payment->user_id, $hold_p_method, $balance_amount, "Payment refused", "coversation/".$payment->id);
        
        $this->balanceUp($payment->user_id, $payment_method, $balance_amount, "Payment refused", "coversation/".$payment->id);


        $payment->the_status = "refused";
        $conversation->the_status = "refused";
        $conversation->save();
        $payment->save();

        // Create new mesasge
        $message = new Message;
        $message->user_id = 0;
        $message->the_type = "controller";

        $message->conversation_id = $conversation->id;
        $message->content = "paymentRefused";
        $message->save();

        $message = new Message;
        $message->user_id = 0;
        $message->the_type = "controller";
        $message->conversation_id = $conversation->id;
        $message->content = $raison;
        $message->save();

        $this->createNotification($conversation->user_id,'paymentRefused','',url('conversation/'.$conversation->id));

        return redirect('server/conversation/'.$conversation->id.'');
    }



    public function refund(acceptPaymentRequest $request){


        $payment_id = $request->input('payment_id');
        $payment = Payment::find($payment_id);
        $this->authorize('refund', $payment);

        $payments_offer = Payments_offer::where('payment_id',$payment_id)->where('the_status', 'paid')->get();
        $balance = Balance::where('user_id', $payment->user_id)->first();


        foreach($payments_offer as $offer){
            $payment_method = $offer->pm_slug;
            $hold_payment_method = 'hold_'.$payment_method;
            $balance_amount = $offer->price;

            $this->balanceUp($payment->user_id, $payment_method, $balance_amount, "Payment refunded (offer ".$offer->id.")", "coversation/".$payment->id);



        }

        $conversation = Conversation::where('payment_id', $payment->id)->first();

        $payment_method = strtolower($payment->payment_method.'_'.$payment->currency);
        $balance_amount = $payment->total;


        $this->balanceUp($payment->user_id, $payment_method, $balance_amount, "Payment refunded", "coversation/".$payment->id);


        $payment->the_status = "refunded";
        $conversation->the_status = "refunded";
        $conversation->save();
        $payment->save();
        $balance->save();
        // Create new mesasge
        $message = new Message;
        $message->user_id = 0;
        $message->the_type = "controller";
        $message->conversation_id = $conversation->id;
        $message->content = "paymentRefunded";
        $message->save();

        $this->createNotification($conversation->user_id,'receivedRefund','',url('conversation/'.$conversation->id));

        return redirect('server/conversation/'.$conversation->id.'');
    }
}
