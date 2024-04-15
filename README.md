<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
</head>
<body>
<article>
    <header>
        <h1>
            UnX (Unemployment Explorer)
        </h1>
    </header>
    <h2>Cuprins</h2>
    <ul>
        <li>
            <a href="#authors">Autori</a>
        </li>
        <li>
            <a href="#introduction">1. Introducere</a>
            <ul>
                <li><a href="#introduction-purpose">1.1 Scop</a></li>
                <li><a href="#conventions">1.2 Convenție de scriere</a></li>
                <li><a href="#audience">1.3 Publicul țintă</a></li>
                <li><a href="#product-scope">1.4 Scopul produsului</a></li>
                <li><a href="#references">1.5 Referințe</a></li>
            </ul>
        </li>
        <li><a href="#overall">2. Descriere Generală</a>
            <ul>
                <li><a href="#product-perspective">2.1 Perspectiva produsului</a></li>
                <li><a href="#product-functions">2.2 Funcțiile produsului</a></li>
                <li><a href="#users">2.3 Clase și caracteristici ale utilizatorilor</a></li>
                <li><a href="#operating-environment">2.4 Mediul de operare</a></li>
                <li><a href="#documentation">2.5 Documentația pentru utilizator</a></li>
            </ul>
        </li>
        <li><a href="#external">3. Interfețele aplicației </a>
            <ul>
                <li><a href="#user-interface">3.1 Interfața utilizatorului </a>
                    <ul>
                        <li><a href="#nav-bar">3.1.1 Bara de navigație </a></li>
                        <li><a href="#login-page">3.1.2 Pagina de autentificare </a></li>
                        <li><a href="#home-page">3.1.3 Pagina de acasă </a></li>
                        <li><a href="#somajPeJudet">3.1.4 Șomajul pe județe</a></li>
                        <li><a href="#nivelDeEducatie">3.1.5 Nivel de educație</a></li>
                        <li><a href="#grupeDeVarsta">3.1.6 Grupe de vârstă</a></li>
                        <li><a href="#mediu">3.1.7 Mediu </a></li>
                        <li><a href="#perioadaDeTimp">3.1.8 Perioadă de timp </a></li>
                        <li><a href="#buget">3.1.9 Bugetul </a></li>
                        <li><a href="#rataSomajului">3.1.10 Rata șomajului </a></li>
                        <li><a href="#protectieSociala">3.1.11 Protecție socială </a></li>
                        <li><a href="#munca">3.1.12 Muncă </a></li>
                        <li><a href="#ministerulMuncii">3.1.13 Ministerul Muncii </a></li>
                        <li><a href="#comparareAlteTari">3.1.14 Comparare cu alte țări </a></li>
                        <li><a href="#predictiiRate">3.1.15 Predicții șomaj </a></li>
                        <li><a href="#statisticiVizualizare">3.1.16 Statistici și Vizualizare </a></li>
                        <li><a href="#about">3.1.17 Pagina informativa </a></li>
                        <li><a href="#help">3.1.18 Pagina de ajutor </a></li>
                        <li><a href="#admin">3.1.19 Pagina administratorului </a></li>
                        <li><a href="#update">3.1.20 Pagina de update date </a></li>
                        <li><a href="#custom">3.1.21 Pagina de custom </a></li>
                        <li><a href="#custom1">3.1.22 Custom1 </a></li>
                    </ul>
                </li>
                <li><a href="#hardware-interface">3.2 Interfața Hardware </a></li>
                <li><a href="#software-interface">3.3 Interfața Software</a></li>
                <li><a href="#communication-interface">3.4 Interfața de comunicare</a></li>
            </ul>
        </li>
        <li><a href="#system-features">4. Caracteristici ale sistemului</a>
            <ul>
                <li><a href="#management">4.1 Gestionarea contului </a>
                    <ul>
                        <li><a href="#management-1">4.1.1 Descriere și generalități </a></li>
                        <li><a href="#management-2">4.1.2 Actualizarea informațiilor</a></li>
                        <li><a href="#management-3">4.1.3 Condiții de funcționare</a></li>
                    </ul>
                </li>
                <li><a href="#utilizatori">4.2 Secțiunea Utilizatori</a>
                    <ul>
                        <li><a href="#utilizatori-1">4.2.1 Descriere și generalități</a></li>
                        <li><a href="#utilizatori-2">4.2.2 Actualizarea informațiilor</a></li>
                        <li><a href="#utilizatori-3">4.2.3 Condiții de funcționare</a></li>
                    </ul>
                </li>
                <li><a href="#administrator">4.3 Secțiunea Admin</a>
                    <ul>
                        <li><a href="#administrator-1">4.3.1 Descriere și generalități</a></li>
                        <li><a href="#administrator-2">4.3.2 Actualizarea informațiilor</a></li>
                        <li><a href="#administrator-3">4.3.3 Condiții de funcționare</a></li>
                    </ul>
                </li>
                <li><a href="#logout">4.4 Secțiunea Logout</a>
                    <ul>
                        <li><a href="#logout-1">4.4.1 Descriere și generalități</a></li>
                        <li><a href="#logout-2">4.4.2 Actualizarea informațiilor</a></li>
                        <li><a href="#logout-3">4.4.3 Condiții de funcționare</a></li>
                    </ul>
                </li>
                <li><a href="#other">4.5 Alte funcționalități </a>
                    <ul>
                        <li><a href="#other-1">4.5.1 Descriere și generalități</a></li>
                        <li><a href="#other-2">4.5.2 Actualizarea informațiilor</a></li>
                        <li><a href="#other-3">4.5.3 Condiții de funcționare</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href="#non-functional">5.Funcționalități pentru protecție și securitate</a>
            <ul>
                <li><a href="#safety">5.1 Protecția datelor</a></li>
                <li><a href="#security">5.2 Securizarea datelor</a></li>
                <li><a href="#software-attributes">5.3 Calitățile Software </a></li>
            </ul>
        </li>
    </ul>
    <div role="contentinfo">
        <section id="authors" typeof="sa:AuthorsList">
            <h2>Autori</h2>
            <ul>
                <li property="schema:author" typeof="sa:ContributorRole">
            <span typeof="schema:Person">
              <meta content="Denisa" property="schema:givenName">
              <meta content="Delia" property="schema:additionalName">
              <meta content="Iacobuț" property="schema:familyName">
              <span property="schema:name">Iacobuț Denisa-Delia</span>
            </span>
                    <ul>
                        <li property="schema:roleContactPoint" typeof="schema:ContactPoint">
                            <a href="mailto:iacobutdelia02@gmail.com" property="schema:email">iacobutdelia02@gmail.com</a>
                        </li>
                    </ul>
                </li>
                <li property="schema:author" typeof="sa:ContributorRole">
            <span typeof="schema:Person">
              <meta content="Ana" property="schema:givenName">
              <meta content="Maria" property="schema:additionalName">
              <meta content="Bindiu" property="schema:familyName">
              <span property="schema:name">Bindiu Ana-Maria</span>
            </span>
                    <ul>
                        <li property="schema:roleContactPoint" typeof="schema:ContactPoint">
                            <a href="mailto:ana.bindiu33@gmail.com" property="schema:email">ana.bindiu33@gmail.com</a>
                        </li>
                    </ul>
            </ul>
        </section>
    </div>
    <section id="introduction">
        <h3>1. Introducere</h3>
        <section id="introduction-purpose">
            <h4>1.1 Scop</h4>
            <p>
                UnX (Unemployment Explorer) este o aplicație web dezvoltată de studenții menționați în secțiunea de Autori de la Facultatea de
                 Informatică a Universității Alexandru Ioan Cuza. 
                 Scopul acestui document este acela de a prezenta o descriere detaliată a funcționalităților și cerințelor aplicației web.
                 Această aplicație oferă utilizatorilor posibilitatea de vizualizare și de comparare multi-criterială a datelor publice referitoare la șomajul din România. 
                
            </p>
        </section>
        <section id="conventions">
            <h4> 1.2 Convenția documentului</h4>
            <ul>
                <li>
                    Acest document urmează șablonul de documentație a cerințelor software conform IEEE Software
                    Requirements
                    Specification.
                </li>
                <li>
                    Textul <b>îngroșat</b> este folosit pentru a defini noțiuni personalizate sau pentru a accentua
                    concepte
                    importante.
                </li>
            </ul>
        </section>
        <section id="audience">
            <h4>1.3 Publicul țintă</h4>
            <p>
                Acest document este destinat tuturor oamenilor care doresc să afle mai multe informații despre șomaj.
                Pot vizualiza statisticile sub formă de tabel, grafic plăcintă, grafic undă, grafic coloane sau text.
            </p>
        </section>
        <section id="product-scope">
            <h4>1.4 Scopul Produsului</h4>
            <p>
                Scopul aplicației este acela de a oferi utilizatorilor un mediu în care acesția să găsească cât mai ușor informațiile dorite.
                Acestea pot fi comparate sau sortate după nivelul de educație, grupe de vârstă, perioadă de timp, buget, mediu, județ,
                protecție socială, muncă sau Ministerul Muncii.  De asemenea, utilizatorul poate face comparație cu alte țări, poate vedea predicții de rate de șomaj în viitor
                și poate alege perioada de timp, aceasta fiind de minim 12 luni.
                Doar administratorul are posibilitatea de a se loga și a aduce modificări atât bazei de date cât și a aplicației.
            </p>
        </section>
        <section id="references">
            <h4>1.5 Bibliografie</h4>
            <ul>
                <li>Site-ul Tehnologii Web, FII UAIC</li>
                <li>H Rick. IEEE-Template - GitHub</li>
            </ul>
        </section>
    </section>
    <section id="overall">
        <h3>2. Descriere Generală</h3>
        <section id="product-perspective">
            <h4>2.1 Perspectiva produsului</h4>
            <p> UnX (Unemployment Explorer) este o aplicație dezvoltată în cadrul cursului de Tehnologii Web,
                menită să
                ofere informații într-o manieră cât mai ușor de înțeles, oferind posibilitatea utilizatorului de a filtra informațiile dorite.
        </section>
        <section id="product-functions">
            <h4>2.2 Funcționalitățile produsului</h4>
            Fiecare utilizator va avea acces la urmatoarele funcționălități:
            <ul>
                <li>să consulte pagina "Home" și noutățile disponibile</li>
                <li>să acceseze paginile "Șomaj pe județe", "Nivel de educație", "Grupe de vârstă",
                    "Mediu", "Perioadă de timp", "Buget", "Rata șomajului", "Protecție socială", "Muncă",
                    "Ministerul Muncii", "Predicții șomaj" pentru a vizualiza informații specifice fiecărei categorii</li>
                <li>să acceseze pagina "Comparație cu alte țări" unde poate alege două țări între care să se facă comparația.</li>
                <li>să acceseze pagina "Vizualizare" unde poate vizualiza informațiile în mai multe moduri</li>
                <li>să acceseze pagina "Custom" de unde poate filtra mai ușor datele pe care dorește să le afle</li>
                <li>să acceseze pagina "Despre" pentru a accesa scurtă descriere a paginii web</li>
                <li>să acceseze pagina "Ajutor" pentru a beneficia de sfaturi în vederea utilizării aplicației</li>
                <li>dacă este <b>autentificat</b>, să acceseze pagină "Update" unde poate aduce modificări aplicației</li>
                <li>dacă utilizatorul are rol de <b>admin</b>, acesta poate face o copie de siguranță a datelor </li>
                <li>dacă utilizatorul are rol de <b>admin</b>, acesta poate face exportul bazei de date</li>
                <li>dacă utilizatorul are rol de <b>admin</b>, acesta poate face exportul fișierelor din baza de date destinate Ministerului</li>
                <li>dacă utilizatorul are rol de <b>admin</b>, acesta poate gestiona adresele de email</li>
            </ul>
        </section>
        <section id="users">
            <h4>2.3 Clase și caracteristici ale utilizatorilor</h4>
            <h5>2.3.1 Utilizator principal</h5>
            <ul>
                <li>Utilizatorii autentificați pot fi:</li>
                <li style="list-style: none">
                    <ul>
                        <li>Doar administratorul ce poate aduce modificări aplicației.
                        </li>
                    </ul>
                </li>
                <li>
                    Utilizatorii neautentificați pot fi:
                    <ul>
                        <li>Orice categorie de oameni ce dorește să obțină date și informații despre șomajul din România. </li>
                    </ul>
                </li>
            </ul>
            <h5>2.3.2 Caracteristici</h5>
            <ul>
                <li>Utilizatorul care este <b> autentificat </b> poate accesa atât pagina "Update"
                cât și cele două pagini ce oferă detalii și sfaturi cu privire la aplicație, "Despre" și "Ajutor".
                    Mai mult, acesta poate gestiona adresele de email, poate aduce modificări bazei de date și poate vizualiza activitatea aplicației.
                </li>
                <li>Utilizatorii care nu sunt  <b> autentificați </b> pot să vizualizeze tot felul de informații și date referitoare la șomajul din România
                    și pot face un custom-view în funcție de preferințele fiecăruia.
                </li>
            </ul>
        </section>
        <section id="operating-environment">
            <h4>2.4 Mediul de operare</h4>
            <p>
                Produsul dezvoltat poate fi utilizat pe orice dispozitiv cu un browser web care suportă HTML5, CSS și
                JavaScript.
            </p>
        </section>
        <section id="documentation">
            <h4>2.5 Documentația pentru utilizator</h4>
            <p>
                Utilizatorii pot consulta acest document pentru explicații detaliate despre funcționalitățile aplicației
                web.
            </p>
        </section>
    </section>
    <section id="external">
        <h3>3. Interfețele aplicației</h3>
        <section id="user-interface">
            <h4>3.1 Interfața utilizatorului</h4>
            Mai jos, puteți vedea o prezentare generală a fiecărei pagini a aplicației și funcționalitățile pe care le
            oferă:
            <ul>
                <li id="nav-bar"><b>Bara de navigație</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Aceasta reprezintă meniul de navigare către fiecare pagină a aplicației, prezent pe fiecare
                            pagină totodată.
                        </li>
                        <li class="pictures" style="list-style: none"><img alt="login" src="images/navBar.png" width=800
                        ></li>
                    </ul>
                </li>
                <li id="login-page"><b>Pagina de autentificare</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Această pagină este dedicată doar administratorului.</li>
                        <li>Pentru a se autentifica, adminul trebuie să completeze câmpurile de "Utilizator" și
                            "Parolă" cu
                            credențiale <b>valide</b>, urmând să acționeze butonul <b>Login</b>.
                            <li>  Butonul de <b>"Back"</b> face redirecționarea în pagina <b>"Home"</b>. </li>
                        </li>
                        <li class="pictures" style="list-style: none"><img alt="login" height="400"
                                                                           src="images/loginPage.png" width=800>
                        </li>
                    </ul>
                </li>
                <li id="home-page"><b> Pagina de acasă</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina are rolul de a prezenta informații generale despre șomajul din România din ultimele 12 luni.</li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="images/homePage.png"
                                                                           width=800>
                        </li>
                    </ul>
                </li>
                <li id="somajPeJudet"><b>Șomajul pe județe</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina oferă date și informații despre șomajul din România în funcție de fiecare județ în parte. De asemnea, datele sunt referitoare la ultimele 12 luni.
                            Dacă utilizatorul dorește să afle date doar despre un anumit județ într-o anumită perioadă de timp, poate 
                            accesa butonul <b>"Custom"</b> din pagina home unde poate selecta informațiile după dorințele proprii.
                        </li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="images/learn1.png" width=800>
                        </li>
                    </ul>
                </li>
                <li id="nivelDeEducatie"><b>Nivel de educație</b></li>
                <li style="list-style: none">
                    <ul>
                        <li> Această pagină conține cele mai recente informații despre nivelul de educație din România.</li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="i mages/rulesPage.png"
                                                                           width=800>
                        </li>
                    </ul>
                <li id="grupeDeVarsta"><b>Grupe de vârstă</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina conține date despre toate grupele de vârstă din România.</li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>
                <li id="mediu"><b>Mediu</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina conține date despre tipul de zone din România și statistici despre șomaj în funcție de mediu.</li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>
                <li id="perioadaDeTimp"><b>Perioadă de timp</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina oferă informații despre șomaj în funcție de mai multe perioade de timp</li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>
                
                <li id="buget"><b>Bugetul</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Această pagină oferă date atât despre bugetul pe care România îl are, cât și despre bugetul fiecărui județ.</li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>
                
                <li id="rataSomajului"><b>Rata șomajului</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina conține informații despre rata șomajului din România. Datele fiind reprezentate în mai multe moduri.</li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>
                <li id="protectieSociala"><b>Protecție socială</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina oferă informații generale și cât mai recente despre protecția socială din România. </li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>
                
                <li id="munca"><b>Muncă</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Această pagină conține date generale despre munca din România. Atât despre locurile libere cât și o statistică a demisionărilor.</li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>
                
                <li id="ministerulMuncii"><b>Ministerul Muncii</b></li>
                <li style="list-style: none">
                    <ul> 
                        <li>Această pagină oferă utilizatorilor o gamă largă de informații și resurse relevante pentru persoanele afectate de șomaj,
                            precum și pentru angajatori și alte părți interesate.
                        </li>
                        <li>Principalele informații pe care le poți găsi sunt:</li>
                        <li><b>Statistici despre șomaj: </b>  Date actualizate și grafice care prezintă nivelurile de șomaj în țară, ratele de șomaj pe diferite categorii 
                            demografice și informații despre tendințele recente.
                        </li>
                        <li><b>Programe și beneficii: </b>Informații despre programele guvernamentale destinate celor șomeri, inclusiv asistență financiară, 
                            formare profesională, programe de reconversie și alte beneficii sociale.
                        </li>
                        <li><b>Cum să obțineți șomaj: </b>Ghiduri și instrucțiuni despre cum să solicitați beneficii de șomaj, documentele necesare, procedurile de înregistrare și termenele limită.
                        </li>
                        <li><b>Resurse de căutare a locurilor de muncă: </b> Linkuri către portaluri de locuri de muncă online, agenții de recrutare, târguri de carieră și alte
                            resurse utile pentru cei care caută un nou loc de muncă.
                        </li>
                        <li><b>Informații pentru angajatori: </b>Ghiduri pentru angajatori despre cum să-și asiste angajații în situații de șomaj, inclusiv informații despre disponibilitatea
                            de programe de sprijin pentru angajatori care intenționează să facă reduceri de personal sau să ofere asistență în reintegrarea angajaților concediați.
                        </li>
                        <li><b>Legislație și reglementări: </b>Resurse despre legislația și reglementările privind șomajul, inclusiv drepturile și responsabilitățile angajaților și
                            angajatorilor, procedurile de concediere și criteriile de eligibilitate pentru beneficiile de șomaj.
                        </li>
                        <li><b>Contacte și centre de asistență: </b>Informații de contact pentru centrele de asistență pentru șomaj, agențiile guvernamentale relevante și alte 
                            instituții sau organizații care oferă sprijin în această privință.
                        </li>
                        <li><b>Știri și actualizări: </b>Secțiuni dedicate la ultimele știri și actualizări legate de politicile și programele de ocupare a forței de muncă, 
                            schimbările legislative și alte evenimente relevante pentru șomaj și ocuparea forței de muncă.
                        </li>

                        <li class="pictures" style="list-style: none"><img alt="streetSignsRomania"
                                                                           src="images/testList.png" width=800
                        ></li>
                       
                    </ul>
                </li>

                <li id="comparareAlteTari"><b>Comparație cu alte țări</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Această pagină oferă o analiză cuprinzătoare și comparativă între două țări, a ratelor acestora inclusiv factori care influențează nivelurile de șomaj în 
                            fiecare țară. De asemenea, sunt reprezentate grafice și diagrame vizuale care prezintă evoluția ratei de șomaj în timp
                            pentru a facilita înțelegerea și analiza datelor.</li>
                        <li>Utilizatorul poate alege, cu ajutorul unui tabel, două țări între care să facă comparația. </li>
                        <li>După apăsarea butonului <b>"Save" </b>informațiile sunt generate și afișate pe ecran.</li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>

                <li id="predictiiRate"><b>Predicții șomaj</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Deși acest lucru implică incertitudine și riscuri, pagina conține informații despre studiul evoluției ratei de șomaj din țară 
                            în trecut și oferă indicii cu privire la tendințele viitoare. Însă trebuie ținut cont că rezultatele reale pot varia în funcție de evoluția economică, politicile guvernamentale și alți
                             factori imprevizibili.</li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>

                <li id="statisticiVizualizare"><b>Statistici și Vizualizare</b></li>
                <li style="list-style: none">
                    <ul>
                        <li> Această pagină oferă utilizatorul posibilitatea de a vizualiza informațiile și statisticiile în manieră de tabel, 
                            grafic plăcintă, grafic undă, grafic coloane și cartografic. De asemenea, acestea vor putea fi exportate în format CSV, SVG sau PDF.</li>
                        <li class="pictures" style="list-style: none"><img alt="streetSigns"
                                                                           src="images/streetSigns.png" width=800>
                        </li>
                    </ul>
                </li>

                <li id="about"><b>Pagina informativa</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina are rolul de a introduce site-ul UnX pe scurt, prin menționarea unor mici detalii:
                            tehnologii
                            utilizate, numele autorilor, scopul aplicației și bibliografia.
                        </li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="images/aboutPage.png" width=800>
                        </li>
                    </ul>
                <li id="help"><b>Pagina de ajutor</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina are rolul de a prezenta câteva sfaturi pentru a putea beneficia de o experiență
                            completă pe aplicație.
                        </li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="images/helpPage.png"
                                                                           width=800
                                                                           ></li>
                    </ul>
             
                <li id="admin"><b>Pagina Administratorului</b></li>
                <li style="list-style: none">
                    <ul>
                        <li>Pagina afișează interfață pentru <b>adminstrator</b>.</li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="images/admin1.png"
                                                                           width=800>
                        </li>
                        <li>Administratorul are posibilitatea de a adauga sau modifica
                            datele și informațiile, de a face o copie de rezervă a datelor și de a face exportul diferitelor date.
                        <li> Butonul de <b>"Logout"</b> face redirecționarea în pagina <b>"Home"</b>. </li>
                        </li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="images/admin2.png"
                                                                           width=800>
                        </li>
                        
                    </ul>
                </li>
                
                <li id="update"><b>Pagina de update date</b></li>
                <li style="list-style: none">
                    <ul>
                        <li> Prin intermediul acestei pagini, administratorul poate alege ce modificări să fie făcute și unde.
                        </li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="images/helpPage.png"
                                                                           width=800
                                                                           ></li>
                    </ul>


                    <li id="custom"><b>Pagina de custom</b></li>
                    <li style="list-style: none">
                    <ul>
                        <li>Custom este pagina ce oferă informațiile personalizate după filtrarea preferințelor utilizatorului din pagina <b>"custom1"</b>.
                        <li>   Butonul de <b>"Back"</b> face redirecționarea în pagina <b>"Home"</b>. </li>
                        </li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="images/helpPage.png"
                                                                           width=800
                                                                           ></li>
                    </ul>

                    <li id="custom1"><b>Custom1</b></li>
                    <li style="list-style: none">
                    <ul>
                        <li> Pagina <b>"Home"</b> conține un buton <b>"Custom"</b> ce deschide pagina <b>"Custom1"</b>. Aceasta oferă utilizatorului posibilitatea de a filtra cu ajutorul unui tabel 
                            informațiile pe care acesta dorește să le afle.
                        <li> Butonul de <b>"Back"</b> face redirecționarea în pagina <b>"Custom"</b>.  </li>
                        </li>
                        <li class="pictures" style="list-style: none"><img alt="overview" src="images/helpPage.png"
                                                                           width=800
                                                                           ></li>
                    </ul>
            </ul>
            <section id="hardware-interface">
                <h4>3.2 Interfața Hardware</h4>
                <p>
                    Acest produs nu necesită interfețe hardware, funcționând pe orice platformă (calculatoare,
                    laptopuri,
                    telefoane etc.), care are instalată un browser.
                </p>
            </section>
            <section id="software-interface">
                <h4>3.3 Interfața Software</h4>
                <p>
                    Cerințele minime de software includ un browser funcțional, compatibil cu HTML5 și cu JavaScript.
                <h5>Postgres Database</h5>
                Aceasta reprezintă baza de date în care stocăm informații despre fiecare utilizator, view-custom,
                și activitatea acestora într-o memorie cache.
            </section>
            <section id="communication-interface">
                <h4>3.4 Interfața de comunicare</h4>
                <p>
                    Aplicația necesită o conexiune la internet. Standardul de comunicare care va fi utilizat este HTTP.
                </p>
            </section>
            <section id="system-features">
                <h3>4. Caracteristici ale sistemului</h3>
                <section id="management">
                    <h4>4.1 Gestionarea contului</h4>
                    <h5 id="management-1">4.1.1 Descriere și generalități</h5>
                    Dreptul de înregistrare se acordă doar administratorului ce folosește o pereche "Utilizator-parolă" prestabilite.
                    <h5 id="management-2">4.1.2 Actualizarea informațiilor</h5>
                    <ul>
                        <li>
                            Administartorul nu poate modifica username-ul sau parola.
                        </li>
                    </ul>
                    <h5 id="management-3">4.1.3 Condiții de funcționare</h5>
                    <ul>
                        <li>
                            Modificările nu sunt permise indiferent dacă adminul este autentificat sau nu.
                        </li>
                    </ul>
                </section>
                <section id="utilizatori">
                    <h4>4.2 Secțiunea de utilizatori</h4>
                    <h5 id="utilizatori-1">4.2.1 Descriere și generalități</h5>
                    Secțiunea <b>Utilizatori</b> este destinată
                    <b>adminului</b>, care îi oferă posibilitatea
                    de a vizualiza custom-view setat de un utilizator. 
                    <h5 id="utilizatori-2">4.2.2 Actualizarea informațiilor</h5>
                    <ul>
                        <li>
                            Nu poate aduce modificări contului deoarece doar el are dreptul de înregistrare.
                        </li>
                    </ul>
                    <h5 id="utilizatori-3">4.2.3 Condiții de funcționare</h5>
                    <ul>
                        <li>
                            Utilizatorul trebuie să fie autentificat.
                        </li>
                        
                    </ul>
                </section>
                <section id="administrator">
                    <h4>4.3 Secțiunea Admin</h4>
                    <h5 id="administrator-1">4.3.1 Descriere și generalități</h5>
                    Secțiunea <b>Admin</b> este destinată utilizatorilor ce au drepturi de <b>administrator</b> și
                    aceasta
                    oferă facilități pe care un utilizator normal nu le are. În momentul în care adminul accesează
                    panoul de control,
                    va putea adaugă sau modifica date și informații direct de pe platformă. Totodată, acesta este
                    capabil să facă export la baza de date.
                    <h5 id="administrator-2">4.3.2 Actualizare informațiilor</h5>
                    <ul>
                        <li>
                            În momentul în care adminul adaugă o informație nouă aceasta este întregistrată
                            în baza de date.
                        </li>
                    </ul>
                    <h5 id="administrator-3">4.3.3 Condiții de funcționare</h5>
                    <ul>
                        <li>
                            Utilizatorul trebuie să fie autentificat.
                        </li>
                        
                    </ul>
                </section>
                <section id="logout">
                    <h4>4.4 Secțiunea de Logout</h4>
                    <h5 id="logout-1">4.4.1 Descriere și generalități</h5>
                    Secțiunea de <b>Logout</b> are rolul de a deconecta administartorul de pe cont și îl redirecționează
                    către pagina acasă.
                    <h5 id="logout-2">4.4.2 Actualizare informațiilor</h5>
                    <ul>
                        <li>
                            Tokenul de autentificare este eliminat, prin intermediul JWT.
                        </li>
                    </ul>
                    <h5 id="logout-3">4.4.3 Condiții de funcționare</h5>
                    <ul>
                        <li>
                            Administratorul trebuie să fie autentificat.
                        </li>
                    </ul>
                </section>
                <section id="other">
                    <h4>4.5 Alte funcționalități</h4>
                    <h5 id="other-1">4.6.1 Descriere și generalități</h5>
                    În cadrul paginii acasă, utilizatorul poate opta pentru custom-view unde 
                    poate filtra informațiile și datele după preferințele proprii.
                    <h5 id="other-2">4.5.2 Actualizarea informațiilor</h5>
                    <ol>
                        <li>
                            Datele care sunt folosite in fluxul RSS sunt extrase pe baza unui camp actualizat permanent
                            din baza de date.
                        </li>
                    </ol>
                    <h5 id="other-3">4.5.3 Cerințe de funcționare</h5>
                    <ul>
                        <li>
                            Indiferent de situație.
                        </li>
                    </ul>
                </section>
            </section>
            <section id="non-functional">
                <h3>5. Funcționalități pentru protecție și securitate</h3>
                <section id="safety">
                    <h4>5.1 Protecția datelor</h4>
                    <p>
                        Aplicația va asigura confidențialitatea datelor prin intermediul unei criptări.
                    </p>
                </section>
                <section id="security">
                    <h4>5.2 Securizarea datelor</h4>
                    <p>
                        Autorizarea utilizatorilor se face pe baza standardului JWT. Utilizatorii au acces doar la
                        informații legate
                        de progresul în cadrul site-ului, celelalte informații fiind ascunse. Token-ul folosit pentru
                        autorizare este
                        stocat într-un cookie de tip HTTP-only, lucru care previne atacurile de tip XSS. Mai mult, toate
                        datele sunt introduse
                        în baza de date prin intermediul unor <b>prepared statements</b>, care asigură prevenirea SQL
                        Injection.
                    </p>
                </section>
                <section id="software-attributes">
                    <h4>5.3 Calitățile Software</h4>
                    <ul>
                        <li>Adaptabilitate</li>
                        <li>Ușurință în utilizare</li>
                        <li>Flexibilitate</li>
                    </ul>
                </section>
            </section>
        </section>
    </section>
</article>
</body>
</html>