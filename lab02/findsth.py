import pymysql
conn=pymysql.connect(host='127.0.0.1',
                      port=3306,
                     user='root',
                     passwd='',
                     db='lab01',
                     charset="utf8")
cursor=conn.cursor()

import pysolr
solr=pysolr.Solr('http://localhost:8983/solr/lab02',timeout=100)
solr.delete(q="*:*")

sql='SELECT * FROM papers'
cursor.execute(sql)
t=cursor.fetchall()
papers=[]
for i in t:
    papers.append({"PaperID":i[0],"Title":i[1],"Year":i[2],"ConferenceID":i[3]})


cursor.execute('select * from conferences')
m=cursor.fetchall()
for i in range(len(papers)):
    for q in range(len(m)):
        if papers[i]["ConferenceID"]==m[q][0]:
            papers[i].update({"ConferenceName":m[q][1]})
            break


cursor.execute('select * from paper_author_affiliation inner join authors where authors.AuthorID=paper_author_affiliation.AuthorID order by AuthorSequence asc')
a=cursor.fetchall()

sp=0
op=len(a)
for i in range(len(papers)):

    papers[i].update({"Authors'ID":[a[sp][1]]})
    papers[i].update({"Authors'Name":[a[sp][5]]})
    sp+=1
    if sp>=op:
        break
    while a[sp][0] == a[sp-1][0]:
        papers[i]["Authors'ID"].append(a[sp][1])
        papers[i]["Authors'Name"].append(a[sp][5])
        sp += 1
        if sp>=op:
            break

solr.add(papers)
solr.commit()
