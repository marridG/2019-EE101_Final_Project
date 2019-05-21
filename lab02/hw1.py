import pysolr
import pymysql
conn = pymysql.connect(host='127.0.0.1',
                       port=3306,
                       user='root',
                       passwd='',
                       db='lab01',
                       charset='utf8')
cursor = conn.cursor()

solr = pysolr.Solr('http://localhost:8983/solr/lab02', timeout=100)

# solr.delete("*:*")

cursor.execute('SELECT * FROM papers')
fet = cursor.fetchall()
papers = []
for i in fet:
    papers.append({"paperid": i[0],"title": i[1], "publishyear": i[2], "ConferenceID": i[3]})

cursor.execute('SELECT * FROM conferences')
fetcon = cursor.fetchall()
for i in range(len(papers)):
    for q in range(len(fetcon)):
        if papers[i]["ConferenceID"] == fetcon[q][0]:
            papers[i].update({"conference": fetcon[q][1]})
            break

a = 'SELECT * FROM paper_author_affiliation inner join authors where Authors.id=paper_author_affiliation.Authorid'
cursor.execute(a)
fetau = cursor.fetchall()

ds = 0
for i in range(len(papers)):
    papers[i].update({"authorid": [fetau[ds][1]]})
    papers[i].update({"name": [fetau[ds][5]]})
    ds += 1
    if ds >= len(fetau):
        break

solr.add(papers)
solr.commit()
