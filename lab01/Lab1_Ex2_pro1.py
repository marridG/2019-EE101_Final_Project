"""
Error:
when using sql sentences to search for target data:
    pymysql.err.InternalError: (1054, "Unknown column 'xxx' in 'where clause'")
solution: https://blog.csdn.net/fastkeeper/article/details/47783739
e.g.WRONG:      sql_name = "SELECT * FROM students WHERE name=%s"
                cursor.execute(sql_name%'zhangsan')...
    CORRECT:    sql_name = "SELECT * FROM students WHERE name='%s'"..
"""
# import pymysql
import Lab1_Ex2_01_init

cursor = Lab1_Ex2_01_init.conn.cursor()

print("--- For a certain PaperID, its Title and PaperPublishYear will be shown.---\n")
target_paper_id = input("Please enter the target PaperID:\n")

# cursor.execute("select Title,PaperPublishYear from papers where PaperID='" + target_paper_id + "'")
sql = "Select Title,PaperPublishYear \
      From papers \
      Where PaperID='%s'"
cursor.execute(sql % (target_paper_id))
# cursor.execute(sql % ("01947C4F"))
sql_result = cursor.fetchall()

print("\n-- PaperID {} --".format(target_paper_id))
for idx, content in enumerate(sql_result):
    print("{}.\tTitle: {}\n\tPaperPublishYear: {}".format(idx + 1, content[0], content[1]))
