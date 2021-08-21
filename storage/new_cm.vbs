Option Explicit
Dim Arg, var1, var2, var3, var4, var5, var6, var7, var8, var9, var10, var11, var12, var13, var14, var15, var16, var17, var18, var19, var20, var21, var22, var23, var24, var25, var26, var27, var28
Set Arg = WScript.Arguments
'Parameter1, begin with index0
var1 = Arg(0)
var2 = Arg(1)
var3 = Arg(2)
var4 = Arg(3)
var5 = Arg(4)
var6 = Arg(5)
var7 = Arg(6)
var8 = Arg(7)
var9 = Arg(8)
var10 = Arg(9)
var11 = Arg(10)
var12 = Arg(11)
var13 = Arg(12)
var14 = Arg(13)
var15 = Arg(14)
var16 = Arg(15)
var17 = Arg(16)
var18 = Arg(17)
var19 = Arg(18)
var20 = Arg(19)
var21 = Arg(20)
var22 = Arg(21)
var23 = Arg(22)
var24 = Arg(23)
var25 = Arg(24)
var26 = Arg(25)
var27 = Arg(26)
var28 = Arg(27)
Dim xlApp
Dim xlBook
Dim fso
Set fso = CreateObject("Scripting.FileSystemObject")
Dim fullpath
fullpath = fso.GetAbsolutePathName(".")
Set fso = Nothing
'MsgBox var1
'MsgBox var2
Set xlApp = CreateObject("Excel.Application")
'~~> Change Path here
Set xlBook = xlApp.Workbooks.Open("C:\laragon\www\web\storage\createcopy_cm.xlsm", 0, True)
xlApp.Run "test", CStr(var1), CStr(var2), CStr(var3), CStr(var4), CStr(var5), CStr(var6), CStr(var7), CStr(var8), CStr(var9), CStr(var10), CStr(var11), CStr(var12), CStr(var13), CStr(var14), CStr(var15), CStr(var16), CStr(var17), CStr(var18), CStr(var19), CStr(var20), CStr(var21), CStr(var22), CStr(var23), CStr(var24), CStr(var25), CStr(var26), CStr(var27), CStr(var28)
xlApp.DisplayAlerts = False
xlBook.Close
xlApp.DisplayAlerts = True
xlApp.Quit

Set xlBook = Nothing
Set xlApp = Nothing

'WScript.Echo "Finished."
WScript.Quit