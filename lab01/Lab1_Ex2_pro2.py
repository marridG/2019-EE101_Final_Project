# import pymysql
import Lab1_Ex2_01_init

cursor = Lab1_Ex2_01_init.conn.cursor()

print("--- For a certain PaperID, the AuthorID in priority order will be shown.---\n")
target_paper_id = input("Please enter the target PaperID:\n")

cursor.execute("Select AuthorSequence,AuthorID \
               From paper_author_affiliation \
               where PaperID='" + target_paper_id + "'\
               Order by AuthorSequence")
sql_result = cursor.fetchall()

result = list(sql_result)
# result.sort()
print("\n-- PaperID {} --".format(target_paper_id))
for idx, content in enumerate(result):
    print("{}.\tAuthorID: {}".format(idx + 1, content[1]))
