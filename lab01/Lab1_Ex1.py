"""
Problem:
when using executemany():
TypeError: Not enough arguments for format string
    https://stackoverflow.com/questions/34736256/typeerror-not-enough-arguments-for-format-string-for-mysqldb

Add-on:
time:
    https://www.cnblogs.com/anloveslife/p/7729312.html
"""

import pymysql
import Lab1_Ex1_01_FilesProcess

database = "Lab01_test" if Lab1_Ex1_01_FilesProcess.mode else "Lab01"

# create database
conn = pymysql.connect(host="127.0.0.1", port=3306, user="root", passwd="", charset="utf8")
cursor = conn.cursor()
cursor.execute("drop database if exists " + database)
cursor.execute("create database if not exists " + database + " character set UTF8mb4 collate utf8mb4_general_ci")
cursor.close()
conn.close()

# connect database
conn = pymysql.connect(host="127.0.0.1", port=3306, user="root", passwd="", db=database, charset="utf8")
cursor = conn.cursor()

# ----------papers.txt----------START----------
# create table
cursor.execute("CREATE TABLE `papers`(\
              `PaperID` VARCHAR(50) NOT NULL,\
              `Title` VARCHAR(400) NULL,\
              `PaperPublishYear` VARCHAR(50) NULL,\
              `ConferenceID` VARCHAR(10) NULL,\
              PRIMARY KEY (`PaperID`), INDEX `ID` USING BTREE (`PaperID`))\
              ENGINE = InnoDB, DEFAULT CHARACTER SET = utf8mb4")
conn.commit()

# input data
temp = Lab1_Ex1_01_FilesProcess.in_data_1_papers[:]
# print("shadow copy end", len(temp))
# for i in range(len(temp)):
#     if not (i % 100):
#         cursor.executemany("INSERT INTO papers(PaperID,Title,PaperPublishYear,ConferenceID)\
#                    VALUES(%s,%s,%s,%s)", temp[i:i + 100])
#     if not (i % 1000):
#         print(i)
#         conn.commit()
# else:
#     conn.commit()
cursor.executemany("INSERT INTO papers(PaperID,Title,PaperPublishYear,ConferenceID)\
                   VALUES(%s,%s,%s,%s)", temp)
conn.commit()
print("papers.txt write-in END!")
# ----------papers.txt----------END----------


# ----------authors.txt----------START----------
# create table
cursor.execute("CREATE TABLE `authors`(\
              `AuthorID` VARCHAR(10) NULL,\
              `AuthorName` VARCHAR(200) NULL,\
              PRIMARY KEY (`AuthorID`), INDEX `ID` USING BTREE (`AuthorID`))\
              ENGINE = InnoDB, DEFAULT CHARACTER SET = utf8mb4")
conn.commit()

# input data
temp = Lab1_Ex1_01_FilesProcess.in_data_2_authors[:]
cursor.executemany("INSERT INTO authors(AuthorID,AuthorName)\
                   VALUES(%s,%s)", temp)
conn.commit()
print("authors.txt write-in END!")
# ----------authors.txt----------END----------


# ----------conferences.txt----------START----------
# create table
cursor.execute("CREATE TABLE `conferences`(\
              `ConferenceID` VARCHAR(10) NULL,\
              `ConferenceName` VARCHAR(50) NULL,\
              PRIMARY KEY (`ConferenceID`), INDEX `ID` USING BTREE (`ConferenceID`))\
              ENGINE = InnoDB, DEFAULT CHARACTER SET = utf8mb4")
conn.commit()

# input data
temp = Lab1_Ex1_01_FilesProcess.in_data_3_conferences[:]
cursor.executemany("INSERT INTO conferences(ConferenceID,ConferenceName)\
                   VALUES(%s,%s)", temp)
conn.commit()
print("conferences.txt write-in END!")
# ----------conferences.txt----------END----------


# ----------affiliations.txt----------START----------
# create table
cursor.execute("CREATE TABLE `affiliations`(\
              `AffiliationID` VARCHAR(10) NULL,\
              `AffiliationName` VARCHAR(200) NULL,\
              PRIMARY KEY (`AffiliationID`), INDEX `ID` USING BTREE (`AffiliationID`))\
              ENGINE = InnoDB, DEFAULT CHARACTER SET = utf8mb4")
conn.commit()

# input data
temp = Lab1_Ex1_01_FilesProcess.in_data_4_affiliations[:]
cursor.executemany("INSERT INTO affiliations(AffiliationID,AffiliationName)\
                   VALUES(%s,%s)", temp)
conn.commit()
print("affiliations.txt write-in END!")
# ----------affiliations.txt----------END----------


# ----------paper_author_affiliation.txt----------START----------
# create table
cursor.execute("CREATE TABLE `paper_author_affiliation`(\
              `PaperID` VARCHAR(10) NULL,\
              `AuthorID` VARCHAR(10) NULL,\
              `AffiliationID` VARCHAR(10) NULL,\
              `AuthorSequence` VARCHAR(5) NULL,\
              PRIMARY KEY(`PaperID`,`AuthorID`), INDEX `ID` USING BTREE (`PaperID`,`AuthorID`))\
              ENGINE = InnoDB, DEFAULT CHARACTER SET = utf8mb4")
# Notice: Duplicate entry for key PRIMARY PaperID
conn.commit()

# input data
temp = Lab1_Ex1_01_FilesProcess.in_data_5_paper_author_affiliation[:]
cursor.executemany("INSERT INTO paper_author_affiliation(PaperID,AuthorID,AffiliationID,AuthorSequence)\
                   VALUES(%s,%s,%s,%s)", temp)
conn.commit()
print("paper_author_affiliation.txt write-in END!")
# ----------paper_author_affiliation.txt----------END----------


# ----------paper_reference.txt----------START----------
# create table
cursor.execute("CREATE TABLE `paper_reference`(\
              `PaperID` VARCHAR(10) NULL,\
              `ReferenceID` VARCHAR(10) NULL,\
              PRIMARY KEY(`PaperID`,`ReferenceID`),INDEX `ID` USING BTREE (`PaperID`,`ReferenceID`))\
              ENGINE = InnoDB, DEFAULT CHARACTER SET = utf8mb4")
# Notice: Duplicate entry for key PRIMARY PaperID
conn.commit()

# input data
temp = Lab1_Ex1_01_FilesProcess.in_data_6_paper_reference[:]
cursor.executemany("INSERT INTO paper_reference(PaperID,ReferenceID)\
                   VALUES(%s,%s)", temp)
conn.commit()
print("paper_reference.txt write-in END!")
# ----------paper_reference.txt----------END----------


cursor.close()
conn.close()
