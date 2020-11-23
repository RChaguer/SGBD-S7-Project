import random as r
import numpy as np

nbr_club = 6
max_nbr_categrie_by_club = 6
nbr_equipe_by_categorie_by_club = 7

#INPUT_DATABASE
CLUB_NAMES = ['HBC BORDEAUX', 'MONTPELLIER HANDBALL', 'PSG HANDBALL', 'MARSEILLE', 'FENIX TOULOUSE', 'HBC NANTES']


#DATABASE_TO_EXPORT
CLUB = []


def gen_CLUB_NAME(i):
    return CLUB_NAMES[i-1]

def gen_CLUB_DATE(i):
    return r.randint(1970,2010)

def gen_CLUB():
    for i in range(1, nbr_club+1):
        CLUB.append([i, gen_CLUB_NAME(i), gen_CLUB_DATE(i)])

def print_CLUB():
    print("insert into CLUB (ID_CLUB, NOM_CLUB, DATE_CREATION)")
    print("values")
    for i in range(0, nbr_club):
        print("\t("+str(CLUB[i][0])+", '"+CLUB[i][1]+"', "+str(CLUB[i][2])+")", end = ";\n\ncommit ;\n" if i==nbr_club-1 else ",\n")



gen_CLUB()
print_CLUB()