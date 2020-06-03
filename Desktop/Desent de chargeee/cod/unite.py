from tkinter import *
from tkinter import ttk

c=Tk()
c.geometry("250x300+300+300")
c.iconbitmap('img\civil.ico')
c.resizable(0,0)
c.title("Convert Units")

def calcul():
    l1=unit1.get()
    l2=unit2.get()
    if l1=='t' and l2 == 'Kg' or l1=='KN' and l2 == 'N':
        data=num.get()
        res.configure(text=float(data)*1000)
    elif l1 == 't' and l2 == 'KN' or l1 == 'Kg' and l2 == 'N':
        data = num.get()
        res.configure(text=float(data) * 10)
    elif l1 == 'N' and l2 == 'KN' or l1 == 'Kg' and l2 == 't':
        data = num.get()
        res.configure(text=float(data) / 1000)
    elif l1 == 'KN' and l2 == 't' or l1 == 'N' and l2 == 'Kg':
        data = num.get()
        res.configure(text=float(data) / 10)
    elif l1 == 't' and l2 == 'N':
        data = num.get()
        res.configure(text=float(data) * 10000)
    elif l1 == 'KN' and l2 == 'Kg':
        data = num.get()
        res.configure(text=float(data) * 100)

    elif l1 == 'Kg' and l2 == 'KN':
        data = num.get()
        res.configure(text=float(data) / 100)

num=DoubleVar()
call=Entry(c,textvariable=num,width=15).pack(padx=10,pady=20)
unit1 = StringVar()
u1 = ttk.Combobox(c, textvariable=unit1, font=('Aial'), width=15, )
u1['value'] = ('KN', 'N', 't', 'Kg')
u1.current(0)
u1.pack()
Label(c,text='To',font='bold').pack(padx=10,pady=20)
unit2 = StringVar()
u2 = ttk.Combobox(c, textvariable=unit2, font=('Aial'), width=15, )
u2['value'] = ('KN', 'N', 't', 'Kg')
u2.current(1)
u2.pack()
button=Button(c,text='=',font = ("Verdana", 22),relief = GROOVE,border = 0, command=calcul)
button.pack()

res=Label(c,anchor = SE,
    font = ("Verdana", 10),
    background = "#ffffff",
    fg = "#000000",
    width=20)
res.pack()


c.mainloop()