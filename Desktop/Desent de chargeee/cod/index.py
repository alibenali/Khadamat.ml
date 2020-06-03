import json
from tkinter import *
import os
from tkinter import filedialog

win=Tk()
win.iconbitmap('img\civil.ico')
win.resizable(0,0)
win.title('pré dimension et analyse element structural (PAES 2020 1.0)')
BG='#696969'
color1='#162447'
win.configure(bg=BG)
def arwah():
    os.system('dc.exe')


Label(text='pré dimension et analyse des elements structural (PAES 2020 1.0)',bg=BG , fg=color1 ,font=('Aharoni',12,'bold')).grid(row=0 ,column=0,columnspan=3,sticky='snew')
plancher=Button(text='plancher',width=20 , height=5,bg=BG,fg='#ffffff',font=('Aharoni',12,'bold'),command= lambda : arwah()  )
plancher.grid(row=2 ,column=0)
poutre=Button(text='poutre',width=20 , height=5,bg=BG,fg='#ffffff',font=('Aharoni',12,'bold'))
poutre.grid(row=2 ,column=1)
poteau=Button(text='poteau',width=20 , height=5,bg=BG,fg='#ffffff',font=('Aharoni',12,'bold'))
poteau.grid(row=3 ,column=1)
escalier=Button(text='escalier',width=20 , height=5,bg=BG,fg='#ffffff',font=('Aharoni',12,'bold'))
escalier.grid(row=3 ,column=0)
balcon=Button(text='Balcon',width=20 , height=5,bg=BG,fg='#ffffff',font=('Aharoni',12,'bold'))
balcon.grid(row=2 ,column=2)
Analyse_sismique=Button(text='Analyse sismique\n(RPA 2003)',width=20 , height=5,bg=BG,fg='#ffffff',font=('Aharoni',12,'bold'))
Analyse_sismique.grid(row=3,column=2)
ferraillage=Button(text='ferraillage',width=20 , height=5,bg=BG,fg='#ffffff',font=('Aharoni',12,'bold'))
ferraillage.grid(row=4,column=1)
win.mainloop()

####### Abdelouahab Mohammed Nabil