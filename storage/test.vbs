Option Explicit
Dim Arg, var1, var2, var3, var4, var5, var6, var7, var8, var9, var10, var11, var12, var13, var14, var15, var16, var17, var18, var19, var20, var21, var22, var23, var24, var25
'Set Arg = WScript.Arguments
'Parameter1, begin with index0
var1 = "C:\laragon\www\storage\Peekaboo Cabled Sweater Variables_in.xlsx"
var2 = "C:\laragon\www\storage\1594707084-6.Xlsx"
var3 = "Womans Cabled Cardigan"
var4 = "6"
var5 =  "8.5"
var6 = "3"
var7 = "38"
var8 = "0"
var9 = "19"
var10 = "27"
var11 = "0"
var12 = "33"
var13 = "0"
var14 = "6"
var15 = "9.5"
var16 = "11"
var17 = "19"
var18 = "9"
var19 = "10"
var20 = "8"
var21 = "14"
var22 = "15"
var23 = "12"
var24 = "2"
var25 = "1"
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
Set xlBook = xlApp.Workbooks.Open("C:\laragon\www\storage\createcopy.xlsm", 0, True)
xlApp.Run "test", CStr(var1), CStr(var2), CStr(var3), CStr(var4), CStr(var5), CStr(var6), CStr(var7), CStr(var8), CStr(var9), CStr(var10), CStr(var11), CStr(var12), CStr(var13), CStr(var14), CStr(var15), CStr(var16), CStr(var17), CStr(var18), CStr(var19), CStr(var20), CStr(var21), CStr(var22), CStr(var23), CStr(var24), CStr(var25)
xlApp.DisplayAlerts = False
xlBook.Close
xlApp.DisplayAlerts = True
xlApp.Quit

Set xlBook = Nothing
Set xlApp = Nothing

'WScript.Echo "Finished."
WScript.Quit