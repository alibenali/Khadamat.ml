from tkinter import *
class about:
    def __init__(self):

            root = Tk()
            root.geometry('500x500')
            root.title('information')
            root.iconbitmap('img\civil.ico')
            backgrd = '#c4c4c4'
            color1 = '#162447'
            color2 = '#A52A2A'
            Label(root,text="About Programme",fg=color1,font=('Aharoni',12,'bold')).pack()
            Label(root, text="",height=10).pack()
            Label(root , text="About the programmer",fg=color1,font=('Aharoni',12,'bold')).pack()
            Label(root, text="",height=10).pack()
            root.mainloop()