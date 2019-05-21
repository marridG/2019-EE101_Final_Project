# coding:utf-8
import codecs

mode = 0
# mode = input("Mode: 1 = test, 0 = all:\n")

print("|||||| Mode: TEST ||||||" if mode else "|||||| Mode: ALL ||||||")

if mode:
    FP_1_papers = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\01-papers.txt"
    FP_2_authors = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\02-authors.txt"
    FP_3_conferences = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\03-conferences.txt"
    FP_4_affiliations = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\04-affiliations.txt"
    FP_5_paper_author_affiliation = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\05-paper_author_affiliation.txt"
    FP_6_paper_reference = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\06-paper_reference.txt"
else:
    FP_1_papers = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\papers.txt"
    FP_2_authors = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\authors.txt"
    FP_3_conferences = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\conferences.txt"
    FP_4_affiliations = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\affiliations.txt"
    FP_5_paper_author_affiliation = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\paper_author_affiliation.txt"
    FP_6_paper_reference = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 03\\data\\paper_reference.txt"

"""
using utf-8:
    \ufeff
    will appear at the beginning of the data
Solution:
    using encoding mode utf-8-sig
    https://www.cnblogs.com/chongzi1990/p/8694883.html
"""


def read_process(file_path):
    in_data = []
    with codecs.open(file_path, encoding='utf-8-sig') as f:
        while True:
            line = f.readline()
            if line == '\n' or line == '':
                break
            in_data.append(tuple(line.strip().split('\t')))
        # # print(in_data)
    #     in_data = f.readlines()
    # in_data = [line.strip().split('\t') for line in in_data]
    return in_data[:]


in_data_1_papers = read_process(FP_1_papers)
# print(len(in_data_1_papers))
in_data_2_authors = read_process(FP_2_authors)
in_data_3_conferences = read_process(FP_3_conferences)
in_data_4_affiliations = read_process(FP_4_affiliations)
in_data_5_paper_author_affiliation = read_process(FP_5_paper_author_affiliation)
in_data_6_paper_reference = read_process(FP_6_paper_reference)

print("Files Process END!")
