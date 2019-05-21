import pysolr
import Lab2_Ex2_2_ReadFile

solr = pysolr.Solr('http://localhost:8983/solr/lab02', timeout=100)

solr.delete(q='*:*')

solr.add(Lab2_Ex2_2_ReadFile.data)

solr.commit()
