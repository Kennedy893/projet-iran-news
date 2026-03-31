-- ============================================================
--  IRAN NEWS - Donnees de demonstration realistes
--  6 categories × 2 articles = 12 articles (2025-2026)
-- ============================================================

USE iran_news;

-- ------------------------------
-- CATeGORIES
-- ------------------------------
TRUNCATE TABLE image;
TRUNCATE TABLE article;
TRUNCATE TABLE categorie;

INSERT INTO categorie (libelle) VALUES
('Actualites'),
('Geopolitique'),
('Analyses'),
('Temoignages'),
('Militaire et Conflits'),
('Diplomatie et Sanctions');


-- ------------------------------
-- ARTICLES
-- ------------------------------

-- ==============================
-- 1. Actualites (id_categorie = 1)
-- ==============================
INSERT INTO article (titre, contenu, date_pub, id_categorie) VALUES
(
  'Manifestations a Teheran apres la mort de civils',
  'Des milliers de manifestants ont envahi les rues de Teheran le 14 fevrier 2025, apres que des frappes aeriennes ont cause la mort de plusieurs dizaines de civils dans les quartiers peripheriques de la capitale. Les forces de securite iraniennes ont tente de disperser les foules avec des gaz lacrymogenes, mais la mobilisation est restee massive. Des temoins sur place rapportent des scenes de chaos autour de la place Azadi. Le gouvernement iranien n\'a pas encore communique de bilan officiel. Les reseaux sociaux, partiellement bloques, continuent de diffuser des videos amateurs montrant l\'ampleur des destructions. La communaute internationale suit la situation avec une vive inquietude, plusieurs ambassades ayant conseille a leurs ressortissants de quitter le pays dans les meilleurs delais.',
  '2025-02-14',
  1
),
(
  'Coupures d\'electricite generalisees dans plusieurs provinces iraniennes',
  'Depuis le debut du mois de mars 2025, de nombreuses provinces iraniennes font face a des coupures d\'electricite prolongees, allant de 8 a 16 heures par jour. Les autorites attribuent ces pannes a la fois aux dommages causes par les recents conflits sur les infrastructures energetiques et a une forte demande hivernale. Les hôpitaux de Tabriz, Ispahan et Ahvaz fonctionnent desormais principalement grâce a des generateurs de secours. La population civile, deja fragilisee par les penuries alimentaires, vit dans des conditions particulierement difficiles. Des organisations humanitaires internationales demandent un acces urgent aux zones les plus touchees pour acheminer du materiel medical et des vivres. Le gouvernement a annonce un plan d\'urgence pour la restauration partielle du reseau electrique d\'ici la fin du mois.',
  '2025-03-08',
  1
),

-- ==============================
-- 2. Geopolitique (id_categorie = 2)
-- ==============================
(
  'Le rôle de la Russie et de la Chine dans le conflit iranien',
  'Alors que le conflit en Iran entre dans sa deuxieme annee, les positions de Moscou et Pekin restent determinantes pour l\'evolution de la situation sur le plan international. La Russie, qui maintient des liens militaires etroits avec Teheran, a livre des systemes de defense aerienne malgre les protestations occidentales. La Chine, de son côte, continue d\'acheter du petrole iranien en contournant les sanctions americaines, fournissant ainsi une bouee de sauvetage economique au regime. Ces deux puissances ont bloque a plusieurs reprises les resolutions du Conseil de securite de l\'ONU appelant a un cessez-le-feu. Les analystes estiment que sans l\'accord de Moscou et Pekin, toute solution diplomatique durable reste hors de portee. La situation redefinit les equilibres geopolitiques au Moyen-Orient pour les decennies a venir.',
  '2025-05-20',
  2
),
(
  'L\'Iran et ses voisins : recomposition des alliances regionales',
  'Le conflit iranien a profondement bouleverse la carte des alliances au Moyen-Orient. L\'Arabie Saoudite, longtemps rivale de Teheran, adopte une position de neutralite prudente tout en renforçant discretement ses defenses. La Turquie, membre de l\'OTAN, joue un rôle d\'intermediaire diplomatique tout en accueillant des flux croissants de refugies iraniens sur son territoire. L\'Irak, frontalier de l\'Iran, subit de plein fouet les repercussions economiques et humanitaires du conflit, avec plus d\'un million de deplaces ayant traverse sa frontiere depuis janvier 2025. Israël surveille de pres l\'evolution de la situation, preoccupe par la possible dispersion d\'armements non conventionnels. Cette recomposition des alliances redessine durablement l\'architecture securitaire de toute la region.',
  '2025-07-11',
  2
),

-- ==============================
-- 3. Analyses (id_categorie = 3)
-- ==============================
(
  'Analyse : les fragilites economiques de l\'Iran avant le conflit',
  'Pour comprendre la rapidite avec laquelle le conflit a fragilise l\'etat iranien, il faut revenir sur les failles structurelles de son economie. Avant le declenchement des hostilites, l\'Iran affichait un taux d\'inflation superieur a 40 %, une monnaie nationale (le rial) en chute libre et un chômage des jeunes atteignant 30 % selon les donnees officielles — probablement sous-estimees. Les sanctions internationales successives depuis 2018 avaient deja coupe le pays d\'une grande partie du systeme financier mondial. Le secteur petrolier, principal pilier de l\'economie, fonctionnait bien en deça de ses capacites. Ces fragilites accumulees ont considerablement reduit la resilience de la population face au choc du conflit, amplifiant la crise humanitaire. Aujourd\'hui, le PIB iranien aurait recule de pres de 20 % depuis le debut des hostilites, selon les estimations du FMI.',
  '2025-04-03',
  3
),
(
  'Peut-on encore parler d\'unite nationale en Iran ?',
  'La question de la cohesion nationale iranienne se pose avec une acuite particuliere en cette periode de conflit. L\'Iran est un etat multiethnique : Perses, Azeris, Kurdes, Arabes et Baloutches cohabitent sur un territoire aux dynamiques centrifuges potentiellement puissantes. Depuis le debut des hostilites, plusieurs mouvements separatistes kurdes et arabes du Khouzestan ont profite de l\'affaiblissement du pouvoir central pour etendre leur influence dans leurs regions respectives. Le gouvernement central de Teheran peine a maintenir son autorite sur l\'ensemble du territoire. Des analystes politiques evoquent le risque d\'une fragmentation de facto du pays si le conflit se prolonge encore deux a trois ans. D\'autres, plus optimistes, rappellent la forte identite nationale iranienne forgee sur des millenaires d\'histoire et estiment qu\'elle constitue un ciment suffisant pour resister a l\'epreuve.',
  '2025-09-17',
  3
),

-- ==============================
-- 4. Temoignages (id_categorie = 4)
-- ==============================
(
  'Leila, 34 ans : "Nous avons tout quitte en une nuit"',
  '"Le 3 mars 2025, vers 2 heures du matin, nous avons entendu les premieres explosions a moins de deux kilometres de notre maison a Ispahan. Mon mari a pris nos deux enfants dans les bras, j\'ai attrape nos papiers d\'identite et quelques vêtements dans un sac, et nous sommes partis a pied." Leila, 34 ans, institutrice, raconte avec une voix posee mais des mains qui tremblent son exil force. Apres trois jours de marche et plusieurs checkpoints militaires, sa famille a reussi a passer la frontiere turque. Elle vit aujourd\'hui dans un camp de refugies pres de Van, dans l\'est de la Turquie. "Ce qui me manque le plus, ce sont les photos de mes parents decedes, restees a la maison. Le reste, on peut le reconstruire." Elle espere rejoindre une cousine etablie en France d\'ici la fin de l\'annee.',
  '2025-06-22',
  4
),
(
  'Reza, medecin a Ahvaz : "On opere a la lampe frontale"',
  'Reza a 41 ans et exerce la chirurgie depuis quinze ans a l\'hôpital Razi d\'Ahvaz, dans le sud-ouest de l\'Iran. Depuis le debut du conflit, son quotidien a radicalement change. "On reçoit parfois trente blesses graves en une seule journee. On manque de morphine, de poches de sang, de materiel sterile. Quand le generateur tombe en panne, on opere a la lampe frontale." Il temoigne pour la premiere fois aupres d\'un media etranger, au risque de sa securite. "Je ne suis pas un heros. Je fais simplement mon metier. Mais j\'ai peur que le monde ne sache pas ce qui se passe vraiment ici." Il appelle les organisations medicales internationales a intensifier leur soutien logistique, precisant que Medecins Sans Frontieres est la seule ONG encore presente dans sa ville.',
  '2025-08-05',
  4
),

-- ==============================
-- 5. Militaire et Conflits (id_categorie = 5)
-- ==============================
(
  'Bilan militaire : six mois d\'operations dans le nord-ouest iranien',
  'Six mois apres le debut des operations militaires dans les provinces du nord-ouest iranien, un premier bilan peut être dresse. Les forces armees iraniennes ont perdu le contrôle de plusieurs positions strategiques dans la region de l\'Azerbaïdjan occidental, notamment autour du lac d\'Ourmia. Les drones de combat, massivement utilises des deux côtes, ont profondement modifie les tactiques employees sur le terrain. Les frappes de precision ont cible les infrastructures logistiques, rendant l\'approvisionnement en carburant et en munitions particulierement difficile pour les unites avancees. Les pertes humaines restent difficiles a chiffrer avec precision en raison du black-out d\'information impose par Teheran, mais les estimations d\'observateurs independants font etat de plusieurs milliers de soldats tues ou blesses de chaque côte.',
  '2025-10-14',
  5
),
(
  'L\'utilisation de drones dans le conflit iranien : une guerre du futur',
  'Le conflit iranien est en train de s\'imposer comme le premier grand laboratoire des guerres de drones a grande echelle du XXIe siecle. Des essaims de drones kamikaze bon marche sont utilises pour saturer les defenses aeriennes adverses avant des frappes de missiles plus coûteux. Les deux camps ont recours a des drones de reconnaissance autonomes capables de fonctionner sans operateur humain pendant plusieurs heures. Des experts militaires du monde entier observent ce conflit pour en tirer les enseignements pour leurs propres armees. Les drones d\'origine iranienne, deja reputes depuis leur utilisation en Ukraine, ont evolue techniquement et se revelent difficiles a intercepter avec les systemes de defense conventionnels. Cette guerre redefinit les doctrines militaires et pose des questions ethiques fondamentales sur la place de l\'humain dans les decisions de vie et de mort au combat.',
  '2026-01-29',
  5
),

-- ==============================
-- 6. Diplomatie et Sanctions (id_categorie = 6)
-- ==============================
(
  'Nouvelles sanctions americaines : quel impact reel sur l\'economie iranienne ?',
  'Le Tresor americain a annonce en novembre 2025 un nouveau paquet de sanctions ciblant une cinquantaine d\'entreprises et d\'individus accuses de contribuer a l\'effort de guerre iranien. Ces mesures visent notamment des societes petrolieres operant via des pavillons de complaisance ainsi que des reseaux de financement bases a Dubaï et a Kuala Lumpur. Mais l\'efficacite reelle de ces sanctions est debattue parmi les economistes. D\'un côte, elles compliquent indeniablement les transactions financieres internationales de l\'Iran. De l\'autre, Teheran a depuis des annees developpe des circuits alternatifs, notamment avec la Chine et la Russie, qui permettent de contourner une partie des restrictions. Le rial iranien a cependant atteint un nouveau plancher historique en decembre 2025, signe que la pression economique reste significative sur la population.',
  '2025-11-18',
  6
),
(
  'Pourparlers a Geneve : une lueur d\'espoir diplomatique ?',
  'Des representants iraniens et americains se sont retrouves discretement a Geneve en fevrier 2026 pour des discussions exploratoires sous l\'egide de la Suisse et du Qatar. C\'est la premiere rencontre directe de haut niveau depuis le debut du conflit. Les deux parties ont confirme la tenue de ces entretiens sans en divulguer le contenu, parlant simplement de "premieres discussions preliminaires". Des diplomates europeens, qui jouent un rôle de facilitateurs, se veulent prudemment optimistes. Les points de blocage restent nombreux : le sort des prisonniers de guerre, la question du programme nucleaire iranien et les conditions d\'un eventuel cessez-le-feu figurent en tête de l\'agenda. La communaute internationale retient son souffle, esperant que cette initiative genevoise marque le debut d\'un processus de paix durable.',
  '2026-02-10',
  6
);

-- ------------------------------
-- IMAGES (1 primaire + 1 secondaire par article)
-- ------------------------------
INSERT INTO image (chemin, type_image, id_article) VALUES
('/uploads/iran-manifestations-teheran-civils-primary.jpeg', 1, 1), ('/uploads/iran-manifestations-teheran-civils-secondary.jpeg', 2, 1),
('/uploads/iran-coupures-electricite-provinces-primary.jpeg', 1, 2), ('/uploads/iran-coupures-electricite-provinces-secondary.jpeg', 2, 2),
('/uploads/iran-russie-chine-conflit-geopolitique-primary.jpeg', 1, 3), ('/uploads/iran-russie-chine-conflit-geopolitique-secondary.jpeg', 2, 3),
('/uploads/iran-recomposition-alliances-regionales-primary.jpeg', 1, 4), ('/uploads/iran-recomposition-alliances-regionales-secondary.jpeg', 2, 4),
('/uploads/iran-fragilites-economiques-analyse-primary.jpeg', 1, 5), ('/uploads/iran-fragilites-economiques-analyse-secondary.jpeg', 2, 5),
('/uploads/iran-unite-nationale-tensions-ethniques-primary.jpeg', 1, 6), ('/uploads/iran-unite-nationale-tensions-ethniques-secondary.jpeg', 2, 6),
('/uploads/iran-exil-famille-isfahan-temoignage-primary.jpeg', 1, 7), ('/uploads/iran-exil-famille-isfahan-temoignage-secondary.jpeg', 2, 7),
('/uploads/iran-medecin-ahvaz-hopital-temoignage-primary.jpeg', 1, 8), ('/uploads/iran-medecin-ahvaz-hopital-temoignage-secondary.jpeg', 2, 8),
('/uploads/iran-bilan-militaire-nord-ouest-primary.jpeg', 1, 9), ('/uploads/iran-bilan-militaire-nord-ouest-secondary.jpeg', 2, 9),
('/uploads/iran-drones-guerre-futur-primary.jpeg', 1, 10), ('/uploads/iran-drones-guerre-futur-secondary.jpeg', 2, 10),
('/uploads/iran-sanctions-americaines-economie-primary.jpeg', 1, 11), ('/uploads/iran-sanctions-americaines-economie-secondary.jpeg', 2, 11),
('/uploads/iran-pourparlers-geneve-diplomatie-primary.jpeg', 1, 12), ('/uploads/iran-pourparlers-geneve-diplomatie-secondary.jpeg', 2, 12);
