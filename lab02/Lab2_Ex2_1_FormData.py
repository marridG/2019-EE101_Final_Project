import pymysql
import codecs

# mode = 1
mode = int(input("Mode: 1 = test, 0 = all: "))

if mode:
    database = "lab01_test"
    FP_out = "C:\\xampp\\htdocs\\EE101-Final_Project\\lab02\\data\\out_test.txt"
    print("|||||| Mode: TEST ||||||")
else:
    database = "lab01"
    FP_out = "C:\\xampp\\htdocs\\EE101-Final_Project\\lab01\\data\\out.txt"
    print("|||||| Mode: ALL ||||||")

conn = pymysql.connect(host="127.0.0.1",
                       port=3306,
                       user="root",
                       passwd="",
                       db=database,
                       charset="utf8")
cursor = conn.cursor()

cursor.execute("Select \
                    A.PaperID,\
                    Title,\
                    B.AuthorID,\
                    AuthorName,\
                    A.ConferenceID,\
                    ConferenceName,\
                    PaperPublishYear,\
                    D.ReferenceID,\
                    E.AffiliationID\
                From \
                    papers A Inner Join \
                    authors B Inner Join \
                    conferences C Inner Join \
                    paper_author_affiliation E Inner Join \
                    paper_reference D\
                ON \
                    A.PaperID=E.PaperID \
                    and B.AuthorID=E.AuthorID \
                    and A.ConferenceID=C.ConferenceID\
                    and A.PaperID=D.PaperID\
                Order by \
                    A.PaperID")
sql_result = cursor.fetchall()
print("Select End~")
result = list(sql_result)
# result = [('c', 'tit_c', 'author_id_0', "author_0", "confid_0", "conf_0", 0),
#           ('a', 'tit_a', 'author_id_1', "author_1", "confid_1", "conf_1", 1),
#           ('a', 'tit_a', 'author_id_2', "author_2", "confid_1", "conf_1", 1),
#           ('a', 'tit_a', 'author_id_3', "author_3", "confid_1", "conf_1", 1),
#           ('b', 'tit_b', 'author_id_4', "author_4", "confid_2", "conf_2", 2)
#           ]

with codecs.open(FP_out, 'w', 'utf-8-sig') as f:
    data = {"PaperID": result[0][0],
            "Title": result[0][1],
            "Authors'ID": [result[0][2]],
            "Authors'Name": [result[0][3]],
            "ConferenceID": result[0][4],
            "ConferenceName": result[0][5],
            "Year": result[0][6],
            "ReferenceID":[result[0][7]]}
#            "AffiliationID":[result[0][8]]}
    for i in range(1, len(result)):
        out_print = False
        if result[i][0] == data["PaperID"]:
            if (result[i][2] not in data["Authors'ID"]):
                data["Authors'ID"].append(result[i][2])
            if (result[i][3] not in data["Authors'Name"]):
                data["Authors'Name"].append(result[i][3])
            if (result[i][7] not in data["ReferenceID"]):
                data["ReferenceID"].append(result[i][7])
#        if result[i][0]==data["PaperID"]:
#            data["AffiliationID"].append(result[i][8])

#        if result[i][0]==data["PaperID"]:


        else:
            f.write(str(data))
            f.write('\n')
            data = {"PaperID": result[i][0],
                    "Title": result[i][1],
                    "Authors'ID": [result[i][2]],
                    "Authors'Name": [result[i][3]],
                    "ConferenceID": result[i][4],
                    "ConferenceName": result[i][5],
                    "Year": result[i][6],
                    "ReferenceID":[result[i][7]]}
#                    "Affiliation":[result[i][8]]}

    f.write(str(data))
    f.write('\n')

"""
Simpe file writing may raise such a problem:
5A74E06C	masdispo...	05856B49	esteban leonsoto	46A05BB0	AAAI	2007
5A74E06C	masdispo...	09301AF1	cristian madrigalmora	46A05BB0	AAAI	2007
5A74E06C	masdispo...	80E06965	sven jacobi	46A05BB0	AAAI	2007
5A74E06C	masdispo...	829444A5	klauspeter fischer	46A05BB0	AAAI	2007
﻿5A74E06C	masdispo...	05856B49	esteban leonsoto	46A05BB0	AAAI	2007
......
"""

print("FORM DATA END!")
