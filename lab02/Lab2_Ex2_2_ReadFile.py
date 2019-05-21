import codecs

# mode = 1
mode = int(input("Mode: 1 = test, 0 = all: "))

if mode:
    FP = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 07\\data\\out_test.txt"
    print("|||||| Mode: TEST ||||||")
else:
    FP = "D:\\Workspace\\Pycharm\\In-Class Exercises\\2018 S2\\Week 07\\data\\out.txt"
    print("|||||| Mode: ALL ||||||")

data = []
with codecs.open(FP, 'utf-8-sig') as f:
    while True:
        line = f.readline()
        if line == '\n' or line == '':
            break
        data.append(eval(line))

print("Read File END!")
