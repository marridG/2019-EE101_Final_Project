import pysolr

solr = pysolr.Solr('http://localhost:8983/solr/lab02', timeout=100)

solr.delete(q='*:*')

solr.add([
    {
        "PaperID": "doc_1",
        "AuthorID": {"1", "2"},
    },
    {
        "PaperID": "doc_2",
        "AuthorID": ["1", "2"],
    },
    {
        "PaperID": "doc_3",
        "AuthorID": ("1", "2"),
    },
    {
        "PaperID": "doc_4",
    },
])

solr.commit()

result = solr.search("AuthorID:1")
for i in result:
    print(i)
print("-----")
result = solr.search("AuthorID:2")
for i in result:
    print(i)
