# import pymysql
import Lab1_Ex2_01_init

cursor = Lab1_Ex2_01_init.conn.cursor()

print("--- For a certain PaperID, its cited times will be shown.---\n")
# target_paper_id = "7E441FB7"  # [TEST] 4 times
# target_paper_id = "7FFD2D64"  # [TEST] 2 times
target_paper_id = input("Please enter the target PaperID:\n")

cursor.execute("Select PaperID From \
                paper_reference\
                where ReferenceID='" + target_paper_id + "'")
# In SQL:
# Select Count(PaperID) From paper_reference where ReferenceID='7E441FB7';
sql_result = cursor.fetchall()
# print(sql_result)

print("\n-- PaperID {} --".format(target_paper_id))
print("Cited {} time(s).".format(len(sql_result)))
