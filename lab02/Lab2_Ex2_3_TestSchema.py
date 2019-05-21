import pysolr


def search():
    target_mode = ["Title", "Authors_Name", "ConferenceName"]
    while True:
        print("Please enter the test mode:")
        print("\t1=Title, 2=Authors'Name, 3=ConferenceName, 0=quit")
        mode_input = input()
        if not mode_input.isdigit():
            print("Wrong Input for Mode!")
            continue
        mode = int(mode_input)
        if mode < 0 or int(mode) > 3:
            print("Wrong Input for Mode!")
            continue
        if not mode:
            break

        while True:
            print("Please enter the maximum number " +
                  "of displayed results (a positive integer):")
            maximum_input = input()
            if not maximum_input.isdigit():
                print("Wrong Input for Maximum Number!")
                continue
            maximum = int(maximum_input)
            if maximum <= 0:
                print("Wrong Input for Maximum Number!")
                continue
            break

        print("Please enter the target of", target_mode[mode - 1])
        target = input()

        results = solr.search(
            q="{}:{}".format(target_mode[mode - 1], target),
            sort="PaperID desc", rows=maximum
        )

        print("Found:", results.hits, "results")
        print("The first", maximum,
              "result(s) of \"{} = {}\" is(are):"
              .format
              (target_mode[mode - 1],
               target)
              )
        for idx, content in enumerate(results):
            print("{}.\t{}".format(idx + 1, content))
        print("----------END----------\n")


if __name__ == "__main__":
    solr = pysolr.Solr(
        'http://localhost:8983/solr/lab02', 
        timeout=100)
    search()
