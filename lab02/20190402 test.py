import pysolr

solr = pysolr.Solr('http://localhost:8983/solr/new_core', timeout=100)

# solr.delete(q='PaperID:doc_2')

solr.add([
    {
        "PaperID": "doc_1",
        "PaperName": "A test document",
    },
    {
        "PaperID": "doc_2",
        "PaperName": "The Banana: Tasty or Dangerous",
    },
    {
        "PaperID": "doc_3",
        "PaperName": "The Bananas: DULL",
    },
])
solr.commit()
results = solr.search("PaperName:banana")
