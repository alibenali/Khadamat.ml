import json
import os
from tkinter import *
from tkinter import messagebox, filedialog
from tkinter import ttk
from info import about
################################################################################################################

########################################################
# part for window


window = Tk()
window.title('Descente de charge')
window.resizable(0, 0)
window.geometry('1200x550+80+50')
window.iconbitmap('img\civil.ico')
note = ttk.Notebook(window, width=1200, height=550)
backgrd = '#c4c4c4'
color1 = '#162447'
color2 = '#A52A2A'
tab0 = Frame(note)
tab0.configure(bg=backgrd)
tab1 = Frame(note)
tab1.configure(bg=backgrd)
tab2 = Frame(note)
tab2.configure(bg=backgrd)
tab3 = Frame(note)
tab3.configure(bg=backgrd)
tab4 = Frame(note)
tab4.configure(bg=backgrd)


#################################################################################################################
# part for programming
###################################################################################################################
# function for Save and Open
def Save_as():  # for saving file .txt
    f = filedialog.asksaveasfile(mode='w', defaultextension=".txt")
    if f is None:
        return
    f.write("Évaluation des charges permanentes et surcharges d‘exploitation de plancher a corp creux "+str(hourd.get())+": ")
    f.write("\nla charge permanente G est : " + str(g_res.get()) + " KN/m² ")
    f.write("\nla charge d‘exploitation Q est : " + str(q_res.get()) + " KN/m² ")
    f.write("\nentrax des poutrelles est : " + str(ep0.get()) + " m ")
    f.write("\n la charge Ultime qu est : " + str(qu_res.get()) + " KN/m ")
    f.write("\n la charge service qs est : " + str(qs_res.get()) + " KN/m ")
    f.write("\n ")
    f.write("\n---------------------------------------------------------------------------")
    f.write("\n ")
    f.write("Évaluation des charges permanentes et surcharges d‘exploitation de plancher Dalle plein: ")
    f.write("\nla charge permanente G est : " + str(g_res2.get()) + " KN/m² ")
    f.write("\nla charge d‘exploitation Q est : " + str(q_res2.get()) + " KN/m² ")
    f.write("\n la charge Ultime qu est : " + str(qu_res2.get()) + " KN/m ")
    f.write("\n la charge service qs est : " + str(qs_res2.get()) + " KN/m ")


def Save():  # for saving file .json
    f = filedialog.asksaveasfile(mode='w', defaultextension=".json")
    if f is None:
        return
    data = {
        # first part tab1
        "ep0": str(ep0.get()),
        "ep1": str(ep1.get()),
        "ep2": str(ep2.get()),
        "ep3": str(ep3.get()),
        "Hourdi": str(Hourdi.get()),
        "ep5": str(ep5.get()),
        "ep6": str(ep6.get()),
        "q_res": str(q_res.get()),
        "g_res": str(g_res.get()),
        "qu_res": str(qu_res.get()),
        "qs_res": str(qs_res.get()),
        "us": str(us.get()),
        "bur": str(bur.get()),
        "eco": str(eco.get()),

        # second part tab2

        "ep12": str(ep12.get()),
        "ep22": str(ep22.get()),
        "ep32": str(ep32.get()),
        "ep42": str(ep42.get()),
        "ep52": str(ep52.get()),
        "ep62": str(ep62.get()),
        "q_res2": str(q_res2.get()),
        "g_res2": str(g_res2.get()),
        "qu_res2": str(qu_res2.get()),
        "qs_res2": str(qs_res2.get()),
        "us2": str(us2.get()),
        "bur2": str(bur2.get()),
        "eco2": str(eco2.get()),

    }

    json.dump(data, f)
    f.close()


def ouvrire():  # for open file .json
    file_path = filedialog.askopenfilename()
    print(file_path)
    with open(file_path) as json_file:
        json_data = json.load(json_file)
        # first part tab 1
    ep0.set(json_data["ep0"])
    ep1.set(json_data["ep1"])
    ep2.set(json_data["ep2"])
    ep3.set(json_data["ep3"])
    Hourdi.set(json_data["Hourdi"])
    ep5.set(json_data["ep5"])
    ep6.set(json_data["ep6"])
    q_res.set(json_data["q_res"])
    g_res.set(json_data["g_res"])
    qu_res.set(json_data["qu_res"])
    qs_res.set(json_data["qs_res"])
    us.set(json_data["us"])
    bur.set(json_data["bur"])
    eco.set(json_data["eco"])

    # second part tab 2
    ep42.set(json_data["ep42"])
    ep12.set(json_data["ep12"])
    ep22.set(json_data["ep22"])
    ep32.set(json_data["ep32"])
    ep52.set(json_data["ep52"])
    ep62.set(json_data["ep62"])
    q_res2.set(json_data["q_res2"])
    g_res2.set(json_data["g_res2"])
    qu_res2.set(json_data["qu_res2"])
    qs_res2.set(json_data["qs_res2"])
    us2.set(json_data["us2"])
    bur2.set(json_data["bur2"])
    eco2.set(json_data["eco2"])


def ask_saving():
    result = messagebox.askquestion("Quit", "Save changes before quit?", icon='warning', type='yesnocancel')
    if result == 'yes':
        global saved
        saved = False
        Save()
        if saved == True:
            sys.exit()
        else:
            global filename
            filename = ''
            return
    elif result == 'no':
        sys.exit()
    elif result == 'cancel':
        return


# menu bar
menubar = Menu(window)

# create a pulldown menu, and add it to the menu bar
filemenu = Menu(menubar, tearoff=0)
filemenu.add_command(label="Open", command=ouvrire)
filemenu.add_command(label="Save", command=Save)
filemenu.add_command(label="Save As", command=Save_as)
filemenu.add_separator()
filemenu.add_command(label="Exit", command=window.quit and ask_saving)
menubar.add_cascade(label="File", menu=filemenu)
toolmenu = Menu(menubar, tearoff=0)
toolmenu.add_command(label="calculator", command=lambda: os.system('calculator.exe'))
toolmenu.add_command(label="Convert units", command=lambda: os.system('unite.exe'))
toolmenu.add_command(label="Tableau de ferraillage", command=lambda: os.system('tableaufer.exe'))
menubar.add_cascade(label="Tools", menu=toolmenu)
helpmenu = Menu(menubar, tearoff=0)
helpmenu.add_command(label="About", command=about)
menubar.add_cascade(label="Help", menu=helpmenu)

window.config(menu=menubar)


#######################################################
# first part of G ######################################

###############################################################################################################################
def using():
    ex = us.get()
    button.configure(state='normal')
    if ex == 1:
        bur.configure(state='disable')
        eco.configure(state='disable')
    elif ex == 2:
        eco.configure(state='disable')
        bur.configure(state='normal')
    elif ex == 3:
        bur.configure(state='disable')
        eco.configure(state='normal')


def using2():
    ex2 = us2.get()
    button2.configure(state='normal')
    if ex2 == 1:
        bur2.configure(state='disable')
        eco2.configure(state='disable')
    elif ex2 == 2:
        eco2.configure(state='disable')
        bur2.configure(state='normal')
    elif ex2 == 3:
        bur2.configure(state='disable')
        eco2.configure(state='normal')


def calcul():
    # calcule de carrelage
    g1 = ep1.get()
    # calcule de mortier de pose
    e2 = ep2.get()
    g2 = round(20 * float(e2), 2)
    labeldecharge2.configure(text=g2)
    # calcule lit de sable
    e3 = ep3.get()
    g3 = round(18 * float(e3), 2)
    labeldecharge3.configure(text=g3)
    # calcul DP OU CC

    l = hourd.get()
    if l == ('(12+4)'):
        g4 = 2.6
        labeldecharge4a.configure(text=g4)

    elif l == ('(16+4)'):
        g4 = 2.8
        labeldecharge4a.configure(text=g4)

    elif l == ('(20+4)'):
        g4 = 3.10
        labeldecharge4a.configure(text=g4)
    elif l == ('(25+5)'):
        g4 = 3.8
        labeldecharge4a.configure(text=g4)
    # calcul enduit de platre
    e5 = ep5.get()
    g5 = round(10 * float(e5), 2)
    labeldecharge5.configure(text=g5)
    # calcul cloison légere
    e6 = ep6.get()
    g6 = round(10 * float(e6), 2)
    labeldecharge6.configure(text=g6)

    G = round(g1 + g2 + g3 + g4 + g5 + g6, 2)
    g_res.set(G)

    ##############################################################################
    # second part of Q
    ##############################################################################

    ex = us.get()
    if ex == 1:
        Q = 1.5
        q_res.set(Q)


    elif ex == 2:
        bn = bur.get()
        if (bn == 'Bureaux proprement dits'):
            Q = 2.5
            q_res.set(Q)
        elif (bn == 'Bureaux paysagers'):
            Q = 3.5
            q_res.set(Q)
        elif (bn == 'Halls de réseption'):
            Q = 2.5
            q_res.set(Q)
        elif (bn == 'Halls a guichet'):
            Q = 4
            q_res.set(Q)
        elif (bn == 'salles de réunions'):
            Q = 2.5
            q_res.set(Q)
        elif (bn == 'salle ordinateureet de reprographie'):
            Q = 2.5
            q_res.set(Q)

    elif ex == 3:
        bn = eco.get()
        if (bn == 'Salle de classe'):
            Q = 2.5
            q_res.set(Q)
        elif (bn == 'Amphitéatres'):
            Q = 3.5
            q_res.set(Q)
        elif (bn == 'Ateliers ,Laboratoires'):
            Q = 2.5
            q_res.set(Q)
        elif (bn == 'Circulations'):
            Q = 4
            q_res.set(Q)
        elif (bn == 'salles de réunions'):
            Q = 4
            q_res.set(Q)
        elif (bn == 'Bibliothéques'):
            Q = 4
            q_res.set(Q)
        elif (bn == 'cuisine collectives'):
            Q = 5
            q_res.set(Q)
    entrax = ep0.get()
    if entrax < 1:
        qu = round(((1.35 * G) + (1.5 * Q)) * entrax, 2)
        qu_res.set(qu)

        qs = round((G + Q) * entrax, 2)
        qs_res.set(qs)
    else:
        messagebox.showwarning('Attention', 'Entrez les dimensions en mètres')


def calcul2():
    # calcule de carrelage
    g12 = ep12.get()

    # calcule de mortier de pose
    e22 = ep22.get()
    g22 = round(20 * float(e22), 2)
    labeldecharge22.configure(text=g22)
    # calcule lit de sable
    e32 = ep32.get()
    g32 = round(18 * float(e32), 2)
    labeldecharge32.configure(text=g32)
    # calcul DP OU CC

    e42 = ep42.get()
    g42 = round(25 * float(e42), 2)
    labeldecharge4b.configure(text=g42)

    # calcul enduit de platre
    e52 = ep52.get()
    g52 = round(10 * float(e52), 2)
    labeldecharge52.configure(text=g52)
    # calcul cloison légere
    e62 = ep62.get()
    g62 = round(10 * float(e62), 2)
    labeldecharge62.configure(text=g62)
    G2 = round(g12 + g22 + g32 + g42 + g52 + g62, 2)
    g_res2.set(G2)

    ##############################################################################
    # second part of Q
    ##############################################################################

    ex2 = us2.get()
    if ex2 == 1:
        Q2 = 1.5
        q_res2.set(Q2)


    elif ex2 == 2:
        bn2 = bur2.get()
        if (bn2 == 'Bureaux proprement dits'):
            Q2 = 2.5
            q_res2.set(Q2)
        elif (bn2 == 'Bureaux paysagers'):
            Q2 = 3.5
            q_res2.set(Q2)
        elif (bn2 == 'Halls de réseption'):
            Q2 = 2.5
            q_res2.set(Q2)
        elif (bn2 == 'Halls a guichet'):
            Q2 = 4
            q_res2.set(Q2)
        elif (bn2 == 'salles de réunions'):
            Q2 = 2.5
            q_res2.set(Q2)
        elif (bn2 == 'salle ordinateureet de reprographie'):
            Q2 = 2.5
            q_res2.set(Q2)

    elif ex2 == 3:
        bn = eco2.get()
        if (bn == 'Salle de classe'):
            Q2 = 2.5
            q_res2.set(Q2)
        elif (bn == 'Amphitéatres'):
            Q2 = 3.5
            q_res2.set(Q2)
        elif (bn == 'Ateliers ,Laboratoires'):
            Q2 = 2.5
            q_res2.set(Q2)
        elif (bn == 'Circulations'):
            Q2 = 4
            q_res2.set(Q2)
        elif (bn == 'salles de réunions'):
            Q2 = 4
            q_res2.set(Q2)
        elif (bn == 'Bibliothéques'):
            Q2 = 4
            q_res2.set(Q2)
        elif (bn == 'cuisine collectives'):
            Q2 = 5
            q_res2.set(Q2)

    qu2 = round(((1.35 * G2) + (1.5 * Q2)), 2)
    qu_res2.set(qu2)

    qs2 = round((G2 + Q2), 2)
    qs_res2.set(qs2)
def ht():
    ht=(l.get()/22.5)
    if ht <= 16 :
        n=('12+4')
        naturecorp.set(n)
    elif ht <=20 and ht> 16 :
        n = ('16+4')
        naturecorp.set(n)
    elif ht <=24 and ht> 20 :
        n = ('20+4')
        naturecorp.set(n)
    elif ht <=30 :   # Question for dr RAHAL
        n = ('25+5')
        naturecorp.set(n)
def epdalle():
    a=L.get()
    b=apuisdalle.get()
    if b == 'Dalle sur un seul apuis':
        e=float(a)/20
        res2.configure(text='ep > {}'.format(e))
    elif b == 'Dalle sur deux apuis' :
        e1=round(float(a)/35 ,2 )
        e2=round(float(a)/30 , 2)
        res2.configure(text='{} < ep < {} '.format(e1,e2))
    elif b == 'Dalle sur 3 ou 4 apuis' :
        e1=round(float(a)/50 ,2 )
        e2=round(float(a)/40 , 2)
        res2.configure(text='{} < ep < {} '.format(e1,e2))
###############################################################################################################################
# part for design
##################################################################################################################
# part of pré dimensionnement
Label(tab0, text='1- plancher a corp creux', bg=backgrd,fg=color1, font=('Aharoni', 12, 'bold')).grid(row=0, column=0)
Label(tab0,text=" entrée L la portée la plus longue de poutrelle entre nu d'apuis (cm)" , bg=backgrd, fg='#000000', font=('Aharoni', 10, 'bold')).grid(row=2, column=0)
l=DoubleVar()
Entry(tab0,textvariable=l,width=5).grid(row=2, column=1)
bb=ttk.Button(tab0,text='calcul',command=ht)
bb.grid(row=3, column=0 ,pady=5)
Label(tab0, text= 'plancher a corp creux :  ', bg=backgrd, fg='#000000', font=('Aharoni', 10, 'bold') ).grid(row=4, column=0 )
naturecorp=StringVar()
res=Label(tab0,textvariable=naturecorp,width=9, bg=color2, fg=color1, font=('bold'))
res.grid(row=4 ,column=1)
cc=PhotoImage(file='img\cc1.GIF')
imagecc=Label(tab0,image=cc).grid(row=1, column=0)
vid=Label(tab0,text='',bg=backgrd,width=20).grid(row=0, column=2)

Label(tab0, text='2- plancher a Dalle plein', bg=backgrd,fg=color1, font=('Aharoni', 12, 'bold')).grid(row=0, column=3)
Label(tab0,text=" entrée L la plus petite portée du panneau le plus sollicité (cm)" , bg=backgrd, fg='#000000', font=('Aharoni', 10, 'bold')).grid(row=2, column=3)
L=DoubleVar()
Entry(tab0,textvariable=L,width=5).grid(row=2, column=4)
bb2=ttk.Button(tab0,text='calcul',command=epdalle)
bb2.grid(row=3, column=3 ,pady=5)
apuisdalle=StringVar()
ap = ttk.Combobox(tab0, textvariable=apuisdalle, font=('Aial'), width=20, )
ap['value'] = ('Dalle sur un seul apuis', 'Dalle sur deux apuis', 'Dalle sur 3 ou 4 apuis')
ap.current(0)
ap.grid(row=4, column=3)
res2=Label(tab0,width=13, bg=color2, fg=color1, font=('bold'))
res2.grid(row=4 ,column=4)
dp=PhotoImage(file='img\dp1.gif')
imagecc=Label(tab0,image=dp).grid(row=1, column=3)


# first part of G ######################################

label = Label(tab1, text='Entrer entraxe des poutrelles (m)', bg=backgrd, fg=color1, font=('Aharoni', 12, 'bold')).grid(
    row=0, column=1)
ep0 = DoubleVar()
entry0 = ttk.Entry(tab1, width=9, textvariable=ep0)
entry0.grid(row=0, column=2)

curentetage = Label(tab1, text='Charges permanentes:', fg=color2, bg=backgrd, font=('Aharoni', 12, 'bold'))
curentetage.grid(row=1, column=1)
designiation = Label(tab1, text='Désigniation', fg=color1, bg=backgrd, font=('Aharoni', 11, 'bold'), width=20)
designiation.grid(row=2, column=1)
epaisseure = Label(tab1, text='Ep (m)', fg=color1, bg=backgrd, font=('Aharoni', 11, 'bold'), width=10)
epaisseure.grid(row=2, column=2)
pourespacevide = Label(tab1, width=5, bg=backgrd).grid(row=2, column=4)  # pour l'espace vid de la column 3
charge = Label(tab1, text='Poid surf \n (KN/m²)', fg=color1, bg=backgrd, font=('Aharoni', 11, 'bold'))
charge.grid(row=2, column=5)

# 1ere ligne de charge
label = Label(tab1, text='Revetement',font=('Aial'), bg=backgrd)
label.grid(row=3, column=1)
ep1 = DoubleVar()
labeldecharge1 = Entry(tab1,width=9, fg=color1, textvariable=ep1,font=('bold'))
labeldecharge1.grid(row=3, column=5, sticky='NS')

# 2eme ligne de charge
label = Label(tab1, text='mortier de pose', font=('Aial'), bg=backgrd)
label.grid(row=4, column=1)
ep2 = DoubleVar()
entry2 = Entry(tab1, width=9, textvariable=ep2, )
entry2.grid(row=4, column=2)
labeldecharge2 = Label(tab1, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge2.grid(row=4, column=5, sticky='NS')

# 3eme ligne de charge
label = Label(tab1, text='Lit de sable', font=('Aial'), bg=backgrd)
label.grid(row=5, column=1)
ep3 = DoubleVar()
entry3 = Entry(tab1, width=9, textvariable=ep3)
entry3.grid(row=5, column=2)
labeldecharge3 = Label(tab1, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge3.grid(row=5, column=5)

# 4eme ligne de charge

Hourdi = StringVar()
hourd = ttk.Combobox(tab1, textvariable=Hourdi, font=('Aial'), width=15, )
hourd['value'] = ('(12+4)', '(16+4)', '(20+4)', '(25+5)')
hourd.current(0)
hourd.grid(row=6, column=1)
labeldecharge4a = Label(tab1, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge4a.grid(row=6, column=5)

# 5eme ligne de charge
label = Label(tab1, text='Enduit en platre', font=('Aial'), bg=backgrd)
label.grid(row=7, column=1)
ep5 = DoubleVar()
entry5 = Entry(tab1, width=9, textvariable=ep5)
entry5.grid(row=7, column=2)
labeldecharge5 = Label(tab1, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge5.grid(row=7, column=5)

# 6eme ligne de charge
label = Label(tab1, text='Cloison de séparation', font=('Aial'), bg=backgrd)
label.grid(row=8, column=1)
ep6 = DoubleVar()
entry6 = Entry(tab1, width=9, textvariable=ep6)
entry6.grid(row=8, column=2)
labeldecharge6 = Label(tab1, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge6.grid(row=8, column=5)

#######################################################################################################
# RESULTAT
vid = Label(tab1, height=8, bg=backgrd)
vid.grid(row=10, column=1)  # pour l'espace et le vide

result = Label(tab1, text='RESULTAT FINAL:', font=('Aharoni', 14, 'bold'), fg=color2, bg=backgrd)
result.grid(row=12, column=1)
g = Label(tab1, text='G(KN/m²)=', font=('Aharoni', 11, 'bold'), bg=backgrd, fg=color1)
g.grid(row=11, column=3)
g_res = DoubleVar()
g_result = Label(tab1, font=('Aharoni', 15, 'bold'), bg=color1, width=7, fg=backgrd, textvariable=g_res)
g_result.grid(row=11, column=5)

##############################################################################
# second part of Q
##############################################################################
vid = Label(tab1, width=10, bg=backgrd).grid(row=0, column=6, rowspan=15)
titre = Label(tab1, text='Surcharges d"exploitation :', fg=color2, bg=backgrd, font=('Aharoni', 12, 'bold')).grid(row=1,
                                                                                                                  column=7)
# USAGE HABITAION
us = IntVar()
rdbtn1 = Radiobutton(tab1, value=1, variable=us, text='Usage Habitation', font=('Aial', 10, 'bold'), bg=backgrd,
                     fg=color1, command=using)
rdbtn1.grid(row=2, column=7)
# Batiment de Bureaux
rdbtn2 = Radiobutton(tab1, value=2, variable=us, text='Batiment de Bureaux', font=('Aial', 10, 'bold'), bg=backgrd,
                     fg=color1, command=using)
rdbtn2.grid(row=3, column=7)

bur = ttk.Combobox(tab1, font=('Aial'), width=15, state='disable')
bur['value'] = (
'Bureaux proprement dits', 'Bureaux paysagers', 'Halls de réseption', 'Halls a guichet', 'salles de réunions',
'salle ordinateureet de reprographie')
bur.current(0)
bur.grid(row=3, column=8)

# Ecole
rdbtn3 = Radiobutton(tab1, value=3, variable=us, text='Batiment Scolaires et universitaires', font=('Aial', 10, 'bold'),
                     bg=backgrd, fg=color1, command=using)
rdbtn3.grid(row=4, column=7)

eco = ttk.Combobox(tab1, font=('Aial'), width=15, state='disable')
eco['value'] = (
'Salle de classe', 'Amphitéatres', 'Ateliers ,Laboratoires', 'Circulations', 'salles de réunions', 'Bibliothéques',
'cuisine collectives')
eco.current(0)
eco.grid(row=4, column=8)

vid = Label(tab1, bg=backgrd).grid(row=5, column=7, rowspan=6)

q = Label(tab1, text='Q(KN/m²)=', font=('Aharoni', 11, 'bold'), bg=backgrd, fg=color1)
q.grid(row=11, column=7)
q_res = DoubleVar()
q_result = Label(tab1, font=('Aharoni', 15, 'bold'), bg=color1, width=7, fg=backgrd, textvariable=q_res)
q_result.grid(row=11, column=8)

label = Label(tab1, text='qu (KN/m)=', font=('Aharoni', 11, 'bold'), bg=backgrd, fg=color1).grid(row=13, column=1)
label = Label(tab1, text='qs (KN/m)=', font=('Aharoni', 11, 'bold'), bg=backgrd, fg=color1).grid(row=14, column=1)
qu_res = DoubleVar()
qu_result = Label(tab1, font=('Aharoni', 11, 'bold'), bg=color1, width=7, fg=backgrd, textvariable=qu_res)
qu_result.grid(row=13, column=2)
qs_res = DoubleVar()
qs_result = Label(tab1, font=('Aharoni', 11, 'bold'), bg=color1, width=7, fg=backgrd, textvariable=qs_res)
qs_result.grid(row=14, column=2)

button = Button(tab1, text='CALCUL', width=25, height=2, state='disable', command=calcul)
button.grid(row=10, column=5)

###############################################################################################################################
# part for design
#  2eme Label  ######################################

chargeg = Label(tab2, text='Charges permanentes:', fg=color2, bg=backgrd, font=('Aharoni', 12, 'bold'))
chargeg.grid(row=1, column=1)
designiation = Label(tab2, text='Désigniation', fg=color1, bg=backgrd, font=('Aharoni', 11, 'bold'), width=20)
designiation.grid(row=2, column=1)
epaisseure = Label(tab2, text='Ep (m)', fg=color1, bg=backgrd, font=('Aharoni', 11, 'bold'), width=10)
epaisseure.grid(row=2, column=2)
pourespacevide = Label(tab2, width=5, bg=backgrd).grid(row=2, column=4)  # pour l'espace vid de la column 3
charge = Label(tab2, text='Poid surf \n (KN/m²)', fg=color1, bg=backgrd, font=('Aharoni', 11, 'bold'))
charge.grid(row=2, column=5)

# 1ere ligne de charge
label = Label(tab2, text='revetement', font=('Aial'), bg=backgrd)
label.grid(row=3, column=1)
ep12 = DoubleVar()
labeldecharge12 = Entry(tab2, width=9, fg=color1, font=('bold'),textvariable=ep12)
labeldecharge12.grid(row=3, column=5, sticky='NS')

# 2eme ligne de charge
label = Label(tab2, text='mortier de pose', font=('Aial'), bg=backgrd)
label.grid(row=4, column=1)
ep22 = DoubleVar()
entry22 = Entry(tab2, width=9, textvariable=ep22, )
entry22.grid(row=4, column=2)
labeldecharge22 = Label(tab2, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge22.grid(row=4, column=5, sticky='NS')

# 3eme ligne de charge
label = Label(tab2, text='Lit de sable', font=('Aial'), bg=backgrd)
label.grid(row=5, column=1)
ep32 = DoubleVar()
entry32 = Entry(tab2, width=9, textvariable=ep32)
entry32.grid(row=5, column=2)
labeldecharge32 = Label(tab2, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge32.grid(row=5, column=5)

# 4eme ligne de charge
dall = Label(tab2, text='Dalle Plein', font=('Aial'), bg=backgrd)
dall.grid(row=6, column=1)
labeldecharge4b = Label(tab2, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge4b.grid(row=6, column=5)
ep42 = DoubleVar()
entry42 = Entry(tab2, width=9, textvariable=ep42)
entry42.grid(row=6, column=2)
# 5eme ligne de charge
label = Label(tab2, text='Enduit en platre', font=('Aial'), bg=backgrd)
label.grid(row=7, column=1)
ep52 = DoubleVar()
entry52 = Entry(tab2, width=9, textvariable=ep52)
entry52.grid(row=7, column=2)
labeldecharge52 = Label(tab2, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge52.grid(row=7, column=5)

# 6eme ligne de charge
label = Label(tab2, text='Cloison de séparation', font=('Aial'), bg=backgrd)
label.grid(row=8, column=1)
ep62 = DoubleVar()
entry62 = Entry(tab2, width=9, textvariable=ep62)
entry62.grid(row=8, column=2)
labeldecharge62 = Label(tab2, width=9, bg=color2, fg=color1, font=('bold'))
labeldecharge62.grid(row=8, column=5)

#######################################################################################################
# RESULTAT
vid = Label(tab2, height=8, bg=backgrd)
vid.grid(row=10, column=1)  # pour l'espace et le vide

result = Label(tab2, text='RESULTAT FINAL:', font=('Aharoni', 14, 'bold'), fg=color2, bg=backgrd)
result.grid(row=12, column=1)
g = Label(tab2, text='G(KN/m²)=', font=('Aharoni', 11, 'bold'), bg=backgrd, fg=color1)
g.grid(row=11, column=3)
g_res2 = DoubleVar()
g_result2 = Label(tab2, font=('Aharoni', 15, 'bold'), bg=color1, width=7, fg=backgrd, textvariable=g_res2)
g_result2.grid(row=11, column=5)

##############################################################################
# second part of Q
##############################################################################
vid = Label(tab2, width=10, bg=backgrd).grid(row=0, column=6, rowspan=15)
titre = Label(tab2, text='Surcharges d"exploitation :', fg=color2, bg=backgrd, font=('Aharoni', 12, 'bold')).grid(row=1,
                                                                                                                  column=7)
# USAGE HABITAION
us2 = IntVar()
rdbtn12 = Radiobutton(tab2, value=1, variable=us2, text='Usage Habitation', font=('Aial', 10, 'bold'), bg=backgrd,
                      fg=color1, command=using2)
rdbtn12.grid(row=2, column=7)
# Batiment de Bureaux
rdbtn22 = Radiobutton(tab2, value=2, variable=us2, text='Batiment de Bureaux', font=('Aial', 10, 'bold'), bg=backgrd,
                      fg=color1, command=using2)
rdbtn22.grid(row=3, column=7)

bur2 = ttk.Combobox(tab2, font=('Aial'), width=15, state='disable')
bur2['value'] = (
'Bureaux proprement dits', 'Bureaux paysagers', 'Halls de réseption', 'Halls a guichet', 'salles de réunions',
'salle ordinateureet de reprographie')
bur2.current(0)
bur2.grid(row=3, column=8)

# Ecole
rdbtn32 = Radiobutton(tab2, value=3, variable=us2, text='Batiment Scolaires et universitaires',
                      font=('Aial', 10, 'bold'), bg=backgrd, fg=color1, command=using2)
rdbtn32.grid(row=4, column=7)

eco2 = ttk.Combobox(tab2, font=('Aial'), width=15, state='disable')
eco2['value'] = (
'Salle de classe', 'Amphitéatres', 'Ateliers ,Laboratoires', 'Circulations', 'salles de réunions', 'Bibliothéques',
'cuisine collectives')
eco2.current(0)
eco2.grid(row=4, column=8)

vid = Label(tab2, bg=backgrd).grid(row=5, column=7, rowspan=6)

q = Label(tab2, text='Q(KN/m²)=', font=('Aharoni', 11, 'bold'), bg=backgrd, fg=color1)
q.grid(row=11, column=7)
q_res2 = DoubleVar()
q_result2 = Label(tab2, font=('Aharoni', 15, 'bold'), bg=color1, width=7, fg=backgrd, textvariable=q_res2)
q_result2.grid(row=11, column=8)

label = Label(tab2, text='qu (KN/m)=', font=('Aharoni', 11, 'bold'), bg=backgrd, fg=color1).grid(row=13, column=1)
label = Label(tab2, text='qs (KN/m)=', font=('Aharoni', 11, 'bold'), bg=backgrd, fg=color1).grid(row=14, column=1)
qu_res2 = DoubleVar()
qu_result2 = Label(tab2, font=('Aharoni', 11, 'bold'), bg=color1, width=7, fg=backgrd, textvariable=qu_res2)
qu_result2.grid(row=13, column=2)
qs_res2 = DoubleVar()
qs_result2 = Label(tab2, font=('Aharoni', 11, 'bold'), bg=color1, width=7, fg=backgrd, textvariable=qs_res2)
qs_result2.grid(row=14, column=2)

button2 = Button(tab2, text='CALCUL', width=25, height=2, state='disable', command=calcul2)
button2.grid(row=10, column=5)

#############################################################################################################################
note.add(tab0, text='pré dimensionement')
note.add(tab1, text='Plancher corp creux')
note.add(tab2, text='Plancher Dalle plein')
note.add(tab3, text='Terrasse')
note.add(tab4, text='vérification de la fléche')
note.pack()
window.mainloop()
