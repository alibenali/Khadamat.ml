from tkinter import *
from tkinter import ttk

tab=Tk()
tab.iconbitmap('img\civil.ico')
tab.resizable(0,0)
tab.title("Tableau complet diamètre des armatures")
image=PhotoImage(file='img\ctableau1.GIF')
Label(tab,image=image).pack()

tab.mainloop()