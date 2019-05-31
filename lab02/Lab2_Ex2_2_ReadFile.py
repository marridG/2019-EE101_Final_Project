import codecs

# mode = 1
mode = int(input("Mode: 1 = test, 0 = all: "))

if mode:
    FP = "C:\\xampp\\htdocs\\EE101-Final_Project\\lab02\\data\\out_test.txt"
    print("|||||| Mode: TEST ||||||")
else:

    FP = "C:\\xampp\\htdocs\\EE101-Final_Project\\lab01\\data\\out.txt"
    print("|||||| Mode: ALL ||||||")

data = []
with codecs.open(FP, 'r','utf-8-sig') as f:

    FP = "D:\\xampp\\apache\\final\\EE101-Final_Project\\lab01\\data\\out.txt"
    print("|||||| Mode: ALL ||||||")

data = []
with codecs.open(FP, 'r', 'utf-8-sig') as f:
    while True:
        line = f.readline()
        if line == '\n' or line == '':
            break
        data.append(eval(line))

print("Read File END!")
