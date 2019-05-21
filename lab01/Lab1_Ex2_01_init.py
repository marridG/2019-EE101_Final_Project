import pymysql

mode = 0
# mode = input("Mode: 1 = test, 0 = all:\n")

print("|||||| Mode: TEST ||||||" if mode else "|||||| Mode: ALL ||||||")

database = "lab01_test" if mode else "lab01"

conn = pymysql.connect(
	host="127.0.0.1", 
	port=3306, 
	user="root", 
	passwd="", 
	db=database, 
	charset="utf8")



