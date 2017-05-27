# JustForKids

In dosarul FINAL STATE o sa avem proiectul in starea finala. Am urcat modulul de login si inregistrare si va rog daca doriti 
sa respectati formatul dosarelor.. tot ce tine de php in dosarul "php" tot ce tine de css in "css" etc.

Am facut putine modificari in baza de date plus doua inserari de date si suplimentar pentru login am creat o functie get_max_id() 
in sql pentru a putea obtine un id unic si corespunzator (functia o gasiti in directorul database).

Pentru validare in baza de date avem user_type astfel

0 - copil
1 - parinte
2 - admin

In login.php dupa cum puteti observa dupa logare in funcite de tipul userului suntem redirectionati catre urmatoarele

Pentru admin -> admin.html
       parinte -> parent.html
       copil -> kid.html
    
Id-ul utilizatorului l-am salvat in $_SESSION['id']  care il puteti folosi ulterior in scripturile voastre php.    

Va rog daca doriti sa respectati numele ____.html de mai sus si toate cele mentionate de la inceput 
pt a nu fi nevoiti sa pierdem timp ulterior cand punem tot in FINAL STATE!

Pentru a trimite raporturi pe mail parintilor am creat o adresa de gmail dedicata: 
game.report.status@gmail.com
Din motive de scuritate va rog sa ma contactati personal pentru a va comunica parola.

La adresa link de mai jos aveti un tutorial care va ajuta sa configurati apache si php pentru trimitere email la nivel 
localhost.
http://blog.techwheels.net/send-email-from-localhost-wamp-server-using-sendmail/