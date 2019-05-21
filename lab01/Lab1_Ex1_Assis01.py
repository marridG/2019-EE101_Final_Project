"""
To count the maximum length of all the possible data

Notice:
Simple file-reading function leads to:
    Error:  UnicodeDecodeError: ‘gbk’ codec can’t decode bytes in position 2-3: illegal multibyte sequence
    Solution:   https://www.cnblogs.com/fclbky/articles/4175788.html
"""

import codecs


def papers(mode):
    filepath = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\01-papers.txt" if mode else "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\papers.txt"
    len_0_PaperID = 0
    len_1_Title = 0
    len_2_PaperPublishYear = 0
    len_3_ConferenceID = 0

    with codecs.open(filepath, encoding='utf-8') as f:
        while True:
            line = f.readline()
            # print(line)
            if line == '\n' or line == '':
                break
            line_split = line[:-1].split('\t')
            len_0_PaperID = max(len_0_PaperID, len(line_split[0]))
            len_1_Title = max(len_1_Title, len(line_split[1]))
            len_2_PaperPublishYear = max(len_2_PaperPublishYear, len(line_split[2]))
            len_3_ConferenceID = max(len_3_ConferenceID, len(line_split[3]))
    print("PaperID:", len_0_PaperID)
    print("Title:", len_1_Title)
    print("PaperPublishYear", len_2_PaperPublishYear)
    print("ConferenceID", len_3_ConferenceID)
    print("------------")


def authors(mode):
    filepath = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\02-authors.txt" if mode else "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\authors.txt"
    len_0_AuthorID = 0
    len_1_AuthorName = 0

    with codecs.open(filepath, encoding='utf-8') as f:
        while True:
            line = f.readline()
            # print(line)
            if line == '\n' or line == '':
                break
            line_split = line[:-1].split('\t')
            len_0_AuthorID = max(len_0_AuthorID, len(line_split[0]))
            len_1_AuthorName = max(len_1_AuthorName, len(line_split[1]))
    print("AuthorID:", len_0_AuthorID)
    print("AuthorName:", len_1_AuthorName)
    print("------------")


def conferences(mode):
    filepath = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\03-conferences.txt" if mode else "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\conferences.txt"
    len_0_ConferenceID = 0
    len_1_ConferenceName = 0

    with codecs.open(filepath, encoding='utf-8') as f:
        while True:
            line = f.readline()
            # print(line)
            if line == '\n' or line == '':
                break
            line_split = line[:-1].split('\t')
            len_0_ConferenceID = max(len_0_ConferenceID, len(line_split[0]))
            len_1_ConferenceName = max(len_1_ConferenceName, len(line_split[1]))
    print("ConferenceID:", len_0_ConferenceID)
    print("ConferenceName:", len_1_ConferenceName)
    print("------------")


def affiliations(mode):
    filepath = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\04-affiliations.txt" if mode else "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\affiliations.txt"
    len_0_AffiliationID = 0
    len_1_AffiliationName = 0

    with codecs.open(filepath, encoding='utf-8') as f:
        while True:
            line = f.readline()
            # print(line)
            if line == '\n' or line == '':
                break
            line_split = line[:-1].split('\t')
            len_0_AffiliationID = max(len_0_AffiliationID, len(line_split[0]))
            len_1_AffiliationName = max(len_1_AffiliationName, len(line_split[1]))
    print("AffiliationID:", len_0_AffiliationID)
    print("AffiliationName:", len_1_AffiliationName)
    print("------------")


def paper_author_affiliation(mode):
    filepath = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\05-paper_author_affiliation.txt" if mode else "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\paper_author_affiliation.txt"
    len_0_PaperID = 0
    len_1_AuthorID = 0
    len_2_AffiliationID = 0
    len_3_AuthorSequence = 0

    with codecs.open(filepath, encoding='utf-8') as f:
        while True:
            line = f.readline()
            # print(line)
            if line == '\n' or line == '':
                break
            line_split = line[:-1].split('\t')
            len_0_PaperID = max(len_0_PaperID, len(line_split[0]))
            len_1_AuthorID = max(len_1_AuthorID, len(line_split[1]))
            len_2_AffiliationID = max(len_2_AffiliationID, len(line_split[2]))
            len_3_AuthorSequence = max(len_3_AuthorSequence, len(line_split[3]))
    print("PaperID:", len_0_PaperID)
    print("AuthorID:", len_1_AuthorID)
    print("AffiliationID", len_2_AffiliationID)
    print("AuthorSequence", len_3_AuthorSequence)
    print("------------")


def paper_reference(mode):
    filepath = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\06-paper_reference.txt" if mode else "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\paper_reference.txt"
    len_0_PaperID = 0
    len_1_ReferenceID = 0

    with codecs.open(filepath, encoding='utf-8') as f:
        while True:
            line = f.readline()
            # print(line)
            if line == '\n' or line == '':
                break
            line_split = line[:-1].split('\t')
            len_0_PaperID = max(len_0_PaperID, len(line_split[0]))
            len_1_ReferenceID = max(len_1_ReferenceID, len(line_split[1]))
    print("PaperID:", len_0_PaperID)
    print("ReferenceID:", len_1_ReferenceID)
    print("------------")


mode = input("Mode: 1 = test, 0 = all:\n")
mode = 0
papers(mode)
authors(mode)
conferences(mode)
affiliations(mode)
paper_author_affiliation(mode)
paper_reference(mode)
