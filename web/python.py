#! C:\Users\Amine Gongi\AppData\Local\Programs\Python\Python38\python.exe
import mysql.connector
import numpy as np
np.set_printoptions(precision=3)
from scipy import spatial
import sys
#function to return the index of the connected user in the matrix
def getIndexOfUser(idUser,nbUser):
    conn=mysql.connector.connect(host="localhost",port=3306,user="root",password="",database="donationw")
    cursor=conn.cursor()
    for result in cursor.execute("set @rank=-1;select totals.X from (SELECT (@rank:=@rank+1)div "+str(nbUser)+" as X ,idUser FROM pub_user ) AS totals where totals.idUser="+str(idUser)+";" , multi=True):
        if result.with_rows:
            rows=result.fetchall()
        else:
            continue

    conn.close()
    return rows[0][0]

#Function to transform table user_publicite into matrix
def getMatrixFromDataBase(nbUser,nbPub):
    matrice=np.zeros((nbUser,nbPub))
    for i in np.arange(0,nbPub):
        if(i==0):
            x=0
        else:
            x=i*nbUser

        for j in np.arange(0,nbUser):
            matrice[j,i]=rows[x+j][2]
    return matrice

#function to return cosinus similarity between two users ,; give the matrix returned from the datebase without NaN values
def similarity(matrix,otherUser,connectedUser):
    return (1-spatial.distance.cosine(matrix[otherUser], matrix[connectedUser]))

def similarityToOthers(matrix,nbUser,connectedUser):
    tab=np.zeros(nbUser)
    for i in np.arange(0,nbUser):
        if(i!=connectedUser):
            tab[i]=similarity(matrix,i,connectedUser)
        else: 
            tab[i]=-1
    return tab


def getIndexSimilarUser(tab):
    return np.argmax(tab)

def getRecommendedMatrix(matrice,connectedUser,indexSimilarUser):
    for i in np.arange(0,len(matrice[0])):
        if(np.isnan(matrice[connectedUser][i]) ):
            matrice[connectedUser][i]=matrice[indexSimilarUser][i]
        else:
            matrice[connectedUser][i]=-2
    return matrice

def getIndexOfMostRecommendedPublicite(recMatrix,connectedUser):
    conn=mysql.connector.connect(host="localhost",port=3306,user="root",password="",database="donationw")
    if(np.amax(recMatrix[connectedUser])!=-2):
        maxIndex=np.argmax(recMatrix[connectedUser])
        cursor=conn.cursor()
        cursor.execute("SELECT * FROM `publicite` limit 1 OFFSET "+ str(maxIndex))
        rows=cursor.fetchall()
        maxPubliciteIndex=rows[0][0]
        conn.close()
        return maxPubliciteIndex
    else:
        return -1 # that's means ; all publicité all watched OR the copy of the data from the similar user = -2 -2 -2 Nan ... (without number)
    

conn=mysql.connector.connect(host="localhost",port=3306,user="root",password="",database="donationw")
cursor=conn.cursor()
cursor.execute("""SELECT publicite.titre, fos_user.nom, pub_user.durre FROM fos_user join pub_user ON fos_user.id =pub_user.idUser join publicite ON publicite.id = pub_user.idPub""")
rows=cursor.fetchall()
#for row in rows:
#    print(row)
cursor.execute("""SELECT count(DISTINCT(`idUser`)) , count(DISTINCT(`idPub`))  FROM `pub_user` """)
rows2=cursor.fetchall()
nbUser=rows2[0][0]
#print("nbre user " + str(nbUser))
nbPub=rows2[0][1]
#print("nbre Pub " + str(nbPub))
conn.close()
    
#Test
matrice=getMatrixFromDataBase(nbUser,nbPub)
#print(matrice)
matrix = np.nan_to_num(matrice)  # replace Nan values with 0 
connectedUser=getIndexOfUser(sys.argv[1],nbUser) #first argument is the DataBase id of the connecteed user given by symfony .
similarityArray=similarityToOthers(matrix,nbUser,connectedUser)
#print(similarityArray)
indexSimilarUser=getIndexSimilarUser(similarityArray)
#print("idex similar user " +str(indexSimilarUser))
recMatrix=getRecommendedMatrix(matrice,connectedUser,indexSimilarUser)
#print('----')
#print(recMatrix)

#print("Data Base index Publciité " )
print(str(getIndexOfMostRecommendedPublicite(recMatrix,connectedUser)))
