def CCC(x):
    for i in range(2,x):
        if x%i ==0:
            return False
    return True

n=int(input())

for i in range(2,n//2):
    if CCC(i) and CCC(n-i):
        print(str(i)+"+"+str(n-i))

 