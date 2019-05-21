# coding:utf-8
import pymysql

# 创建数据库
conn = pymysql.connect(host='127.0.0.1', port=3306, user='root', passwd='', charset="utf8")
cursor = conn.cursor()
cursor.execute('drop database if exists test')
cursor.execute('create database if not exists test character set UTF8mb4 collate utf8mb4_general_ci')
conn.close()

# 创建表
conn = pymysql.connect(host='127.0.0.1', port=3306, user='root', passwd='', db='test', charset="utf8")
cursor = conn.cursor()

# cursor.execute('drop table if exists students')
# conn.commit()

cursor.execute('CREATE TABLE `students` ( \
                `id` VARCHAR(10) NOT NULL,\
                `name` VARCHAR(1000) NOT NULL,\
                `age` VARCHAR(10) NOT NULL,\
                `phone` VARCHAR(10) NOT NULL,\
                PRIMARY KEY (`id`),\
                INDEX `ID` USING BTREE (`id`))\
                ENGINE = InnoDB,\
                DEFAULT CHARACTER SET = utf8mb4')
conn.commit()

cursor.execute("INSERT INTO students(id,name,age,phone)\
               VALUES (%s,%s,%s,%s)", ('01', 'zhangsan', '10', '1888888'))
conn.commit()

info = ['12', 'ab', '13', '1843', '14', 'ab', '13', '18436', '16', 'abcd', '17', '18434355', '18', 'abcde', '19',
        '1843345345']
info = [('12', 'ab', '13', '1843'), ('14', 'ab', '13', '18436'), ('16', 'abcd', '17', '18434355'), ('18', 'abcde', '19',
                                                                                                    '1843345345')]

# for i in range(0, len(info), 4):
#     cursor.execute("INSERT INTO students(id,name,age,phone)\
#                         VALUES(%s,%s,%s,%s)", info[i: i + 4])
# conn.commit()
# for i in range(0, len(info), 4):
#     cursor.execute("INSERT INTO students(id,name,age,phone)\
#                         VALUES(%s,%s,%s,%s)", (info[i], info[i + 1], info[i + 2], info[i + 3]))
# conn.commit()
cursor.executemany("insert into students(id,name,age,phone) values(%s,%s,%s,%s)", info[:])
conn.commit()

cursor.execute("SELECT * FROM students")
row = cursor.fetchone()
while row is not None:
    print(row)
    row = cursor.fetchone()

print("---------")

sql_id = "SELECT * FROM students WHERE id=%s"
cursor.execute(sql_id % ("12"))
result = cursor.fetchone()
print(result)

sql_name = 'SELECT * FROM students WHERE age=%s'
cursor.execute(sql_name % ("13"))
print("* age 13 all\t\t{}".format(cursor.fetchall()))

sql_name = 'SELECT name FROM students WHERE age=%s'
cursor.execute(sql_name % ("13"))
print("name age 13 one\t\t{}".format(cursor.fetchone()))

sql_name = 'SELECT name FROM students WHERE age=%s'
cursor.execute(sql_name % ("13"))
print("name age 13 all\t\t{}".format(cursor.fetchall()))

cursor.execute("SELECT * FROM students WHERE age BETWEEN '13' and '17'")
print("* age 13-17 all -V1-\t\t{}".format(cursor.fetchall()))

sql_name = "SELECT * FROM students WHERE age BETWEEN '17' and %s"
cursor.execute(sql_name % ("13"))
print("* age 17-13 all -V2-\t\t{}".format(cursor.fetchall()))

cursor.execute("SELECT * FROM students WHERE age >'13'")
print("* age >13 all -V1-\t\t{}".format(cursor.fetchall()))

sql_name = 'SELECT * FROM students WHERE age>=%s'
cursor.execute(sql_name % ("13"))
print("* age >=13 all -V2-\t\t{}".format(cursor.fetchall()))

sql_name = "SELECT * FROM students WHERE name='zhangsan'"
cursor.execute(sql_name)
print("* name=zhangsan all\t\t{}".format(cursor.fetchall()))

sql_name = "SELECT * FROM students WHERE name='%s'"
cursor.execute(sql_name%'zhangsan')
print("* name=zhangsan all\t\t{}".format(cursor.fetchall()))
