<?php
/**
 * Internationalisation for PrivatePageProtection extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Daniel Kinzler
 */
$messages['en'] = array(
	'privatepp-desc' => 'Allows restricting page access based on user group',
	
	'privatepp-lockout-prevented' => 'Lockout prevented: You have tried to restrict access to this page to {{PLURAL:$2|the group|one of the groups}} $1. 
Since you are not a member of {{PLURAL:$2|this group|any of these groups}}, you would not be able to access the page after saving it. 
Saving was aborted to avoid this.',
);

/** Message documentation (Message documentation)
 * @author Daniel Kinzler
 */
$messages['qqq'] = array(
	'privatepp-desc' => '{{desc}}',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'privatepp-desc' => 'Дазваляе абмяжоўваць доступ да старонак пэўным групам удзельнікам',
	'privatepp-lockout-prevented' => 'Папярэджанае самаабмежаваньне: вы намагаліся абмежаваць доступ да старонкі {{PLURAL:$2|групе|адной з груп}} $1. Паколькі вы не належыце да {{PLURAL:$2|гэтай групы|адной з гэтых груп}}, вы бы не змаглі адкрыць старонку пасьля захаваньня наладаў.
Захаваньне было спыненае, каб пазьбегнуць гэтага.',
);

/** German (Deutsch)
 * @author Daniel Kinzler
 * @author Kghbln
 */
$messages['de'] = array(
	'privatepp-desc' => 'Ermöglicht das Beschränken das Zugangs zu Wikiseiten auf Basis von Benutzergruppen',
	'privatepp-lockout-prevented' => 'Die Aussperrung wurde verhindert: Du hast versucht, den Zugang zu dieser Seite auf {{PLURAL:$2|die Benutzergruppe|die Benutzergruppen}} $1 zu beschränken. 
Da du kein Mitglied {{PLURAL:$2|dieser Benutzergruppe|einer dieser Benutzergruppen}} bist, könntest du nach dem Speichern nicht mehr auf die Seite zugreifen. 
Um dies zu vermeiden, wurde das Speichern abgebrochen.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Daniel Kinzler
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'privatepp-lockout-prevented' => 'Die Aussperrung wurde verhindert: Sie haben versucht, den Zugang zu dieser Seite auf {{PLURAL:$2|die Benutzergruppe|die Benutzergruppen}} $1 zu beschränken. 
Da Sie kein Mitglied {{PLURAL:$2|dieser Benutzergruppe|einer dieser Benutzergruppen}} sind, könnten Sie nach dem Speichern nicht mehr auf die Seite zugreifen. 
Um dies zu vermeiden, wurde das Speichern abgebrochen.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'privatepp-desc' => 'Zmóžnja wobgranicowanje pśistupa na bok na zakłaźe wužywarskeje kupki',
	'privatepp-lockout-prevented' => 'Wuzamknjenje jo se zajźowało: Sy wopytał pśistup k toś tomu bokoju na {{PLURAL:$2|kupku|jadnu z kupkow}} $1 wobgranicowaś. Dokulaž njejsy cłonk {{PLURAL:$2|oś togo kupki|jadneje z toś tych kupkow}}, njeby měł pó składowanju žeden pśistup na bok.
Składowanje jo se pśetergnuło, aby to wobinuło.',
);

/** Spanish (Español)
 * @author Armando-Martin
 */
$messages['es'] = array(
	'privatepp-desc' => 'Permite restringir el acceso a las páginas según el grupo al que pertenezca el usuario',
	'privatepp-lockout-prevented' => 'Bloqueo preventivo: Intentó restringir el acceso a esta página a los miembros {{PLURAL:$2|del grupo|de los grupos}} $1.
Dado que no pertenece a {{PLURAL:$2|este grupo|ninguno de estos grupos}}, no podrá acceder a la página después de guardar.
Se canceló la grabación para evitar esto.',
);

/** French (Français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'privatepp-desc' => "Permet de restreindre l'accès à la page à un groupe d'utilisateurs",
	'privatepp-lockout-prevented' => "Verrouillage empêché: Vous avez essayé de limiter l'accès à cette page {{PLURAL:$2|au groupe|un des groupes}} $1 .
Comme vous n'êtes pas membre de {{PLURAL:$2|ce groupe|un de ces groupes}}, vous ne seriez plus en mesure d'accéder à la page après l'avoir enregistrée.
L'enregistrement a été annulé pour éviter cela.",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'privatepp-desc' => 'Permite restrinxir o acceso ás páxinas segundo o grupo ao que pertenza o usuario',
	'privatepp-lockout-prevented' => 'Bloqueo preventivo: Intentou restrinxir o acceso a esta páxina aos membros {{PLURAL:$2|do grupo|dos grupos}} $1.
Dado que non pertence a {{PLURAL:$2|este grupo|ningún destes grupos}}, non poderá acceder á páxina despois de gardar.
Cancelouse o gardado para evitar isto.',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'privatepp-desc' => 'הגבלת גישה לדף לפי השתייכות לקבוצת משתמשים',
	'privatepp-lockout-prevented' => 'הנעילה נמנעה: ניסית להגביל את הגישה לדף הזה {{PLURAL:$2|לקבוצה|לאחת מהקבוצות הבאות:}} $1.
היות שחשבונך אינו רשום {{PLURAL:$2|בקבוצה הזאת|באחת מהקבוצות האלו}}, לא תהיה לך גישה לדף לאחר שמירתו.
השמירה בוטלה כדי למנוע את זה.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'privatepp-desc' => 'Zmóžnja wobmjezowanje přistupa na strony na zakładźe wužiwarskeje skupiny',
	'privatepp-lockout-prevented' => 'Wuzamknjenje je so zadźěwało: Sy spytał přistup k tutej stronje na {{PLURAL:$2|skupinsku skupinu|jednu ze skupinow}} $1 wobmjezować. Dokelž čłon {{PLURAL:$2|tuteje skupiny|jedneje z tutych skupinow}} njejsy, njeby po składowanju žadyn přistup na stronu měł.
Składowanje je so přetorhnyło, zo by to wobešło.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'privatepp-desc' => 'Permitte restringer le accesso a paginas secundo le gruppo del usator',
	'privatepp-lockout-prevented' => 'Exclusion prevenite: Tu ha tentate limitar le accesso a iste pagina {{PLURAL:$2|al gruppo|a un del gruppos}} $1. 
Post que tu non es membro de {{PLURAL:$2|iste gruppo|alcun de iste gruppos}}, tu non poterea acceder al pagina post salveguardar lo. 
Le salveguarda ha essite abortate pro evitar isto.',
);

/** Italian (italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'privatepp-desc' => "Permette di limitare l'accesso alle pagine in base al gruppo utente",
	'privatepp-lockout-prevented' => "Blocco evitato: stai cercando di limitare l'accesso a questa pagina {{PLURAL:$2|al gruppo|ai gruppi}} $1.
Considerato che tu non sei un membro di {{PLURAL:$2|questo gruppo|nessuno di questi gruppi}}, non sarai più in grado di accedere a questa pagina dopo aver salvato.
Il salvataggio è stato interrotto per evitare questo.",
);

/** Japanese (日本語)
 * @author Shirayuki
 */
$messages['ja'] = array(
	'privatepp-desc' => '利用者グループに基づいてページへのアクセスを制限できるようにする',
);

/** Korean (한국어)
 * @author 아라
 */
$messages['ko'] = array(
	'privatepp-desc' => '사용자 그룹을 바탕으로 문서 접근을 제한하도록 허용',
	'privatepp-lockout-prevented' => '차단 잠금: $1 {{PLURAL:$2|그룹이|그룹 중 하나가}} 이 페이지에 대한 접근을 제한하려 했습니다.
{{PLURAL:$2|이 그룹|그들의 어떤 그룹}}의 구성원이 아니기 때문에, 당신은 그것을 저장한 후 페이지에 접근할 수 없습니다.
저장이 되지 않도록 중단되었습니다.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'privatepp-desc' => 'Määd_et müjjelesch, der Zohjang op Sigge obb_en beschtemmpte Jropp Metmaacher ze bejränze.',
	'privatepp-lockout-prevented' => 'Lockout prevented: You have tried to restrict access to this page to {{PLURAL:$2|the group|one of the groups}} $1. 
Since you are not a member of {{PLURAL:$2|this group|any of these groups}}, you would not be able to access the page after saving it. 
Mer han di Sigg nit afjeschpeischert, domet dat nidd_esu kütt.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'privatepp-desc' => 'Erlaabt et den Accès op Säiten, op Basis vun de Benotzergruppen, ze limitéiern',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'privatepp-desc' => 'Овозможува ограничување на пристапот до страници во зависност од корисничката група',
	'privatepp-lockout-prevented' => 'Ограничувањето на пристапот е спречено: Се обидовте страницата да ја направите пристапна само за членови на {{PLURAL:$2|групата|една од групите}} $1. 
Бидејќи не членувате во {{PLURAL:$2|групата|ниедна од нив}}, самите вие нема да можете да пристапите на неа откако ќе ја зачувате. 
За да се избегне ова, зачувувањето е откажано.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'privatepp-desc' => 'Maakt het mogelijk paginatoegang te beperken volgens gebruikersgroepen',
	'privatepp-lockout-prevented' => 'Beveiliging voorkomen: U hebt geprobeerd toegang tot deze pagina te beperken voor {{PLURAL:$2|de groep|één van de groepen}} $1. Omdat u geen lid bent van {{PLURAL:$2|deze groep|deze groepen}}, zou u geen toegang meer hebben tot deze pagina na ze op te slaan. Het opslaan is afgebroken om dit te voorkomen.',
);

/** Polish (Polski)
 * @author BeginaFelicysym
 */
$messages['pl'] = array(
	'privatepp-desc' => 'Pozwala na ograniczanie dostępu strony na podstawie grupy użytkownika',
	'privatepp-lockout-prevented' => 'Uniemożliwiono blokadę: próbujesz ograniczyć dostęp do tej strony dla {{PLURAL:$2|grupy|jednej z grup}}  $1 .
Ponieważ nie jesteś członkiem  {{PLURAL:$2|tej grupy|żadnej tych grup}}, nie udałoby ci się uzyskać dostępu do strony po zapisaniu tego ustawienia. 
Zapisywanie zostało przerwane aby temu zapobiec.',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'privatepp-desc' => "A përmëtt dë strenze l'acess dla pagina an dovrand la partìa utent",
	'privatepp-lockout-prevented' => "Blòch evità: Ti it l'has provà a strenze l'acess a sta pagina-sì për {{PLURAL:$2|la partìa|un-a dle partìe}} $1. 
Da già ch'it ses pa un mémber {{PLURAL:$2|dë sta partìa|d'un-a dë ste partìe}}, it podrìe pa esse bon a acede a la pagina d'apress d'avejlo salvà.
Ël salvatagi a l'é stait abortì për evité sòn-sì.",
);

