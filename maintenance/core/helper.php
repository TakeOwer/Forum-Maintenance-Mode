<?php
/**
 * Forum Maintenance Mode - phpBB extension
 *
 * @author     Salvo Cortesiano
 * @copyright  (c) 2026-08-11 20:00 CEST Salvo Cortesiano
 * @link       https://netshadows.de/ombra/
 * @license    GNU General Public License, version 2 (GPL-2.0)
 */

namespace salvocortesiano\maintenance\core;

class helper
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\config\db_text */
	protected $config_text;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $adm_path;

	/** Supported front-end languages of the maintenance page */
	const LANGS = array('it', 'en', 'fr', 'de', 'es', 'pt', 'nl', 'pl', 'ru', 'tr', 'el', 'cs', 'ro', 'sv', 'hu', 'ar', 'ja', 'zh_cmn_hans');

	public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\template\template $template, \phpbb\user $user, \phpbb\language\language $language, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\path_helper $path_helper, $root_path, $php_ext, $adm_path)
	{
		$this->config = $config;
		$this->config_text = $config_text;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->auth = $auth;
		$this->request = $request;
		$this->path_helper = $path_helper;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->adm_path = $adm_path;
	}

	/**
	 * Default admin editable texts, per language.
	 */
	public static function default_messages()
	{
		return array(
			'it' => array(
				'title'       => 'Sito in Manutenzione',
				'subtitle'    => 'Stiamo lavorando per migliorare il sito',
				'description' => 'Il sito è temporaneamente non disponibile per manutenzione programmata. Torneremo presto online.',
				'footer'      => 'Torneremo presto online!',
				'notice'      => 'Si avvisa tutti gli utenti ed i releaser che dal {START} al {END} vi sarà un intervento di manutenzione straordinaria del forum. Grazie per la pazienza.',
			),
			'en' => array(
				'title'       => 'Site under maintenance',
				'subtitle'    => 'We are working to improve the site',
				'description' => 'The site is temporarily unavailable due to scheduled maintenance. We will be back online shortly.',
				'footer'      => 'We will be back online soon!',
				'notice'      => 'All users and releasers are advised that the board will undergo extraordinary maintenance from {START} to {END}. Thank you for your patience.',
			),
			'fr' => array(
				'title'       => 'Site en maintenance',
				'subtitle'    => 'Nous travaillons à améliorer le site',
				'description' => 'Le site est momentanément indisponible pour une maintenance programmée. Nous serons de retour très bientôt.',
				'footer'      => 'À très bientôt en ligne !',
				'notice'      => 'Tous les membres sont informés qu\'une maintenance exceptionnelle du forum aura lieu du {START} au {END}. Merci de votre patience.',
			),
			'de' => array(
				'title'       => 'Wartungsarbeiten',
				'subtitle'    => 'Wir arbeiten an Verbesserungen der Seite',
				'description' => 'Die Seite ist wegen geplanter Wartungsarbeiten vorübergehend nicht erreichbar. Wir sind bald wieder online.',
				'footer'      => 'Wir sind bald wieder da!',
				'notice'      => 'Alle Mitglieder werden darauf hingewiesen, dass vom {START} bis zum {END} außerplanmäßige Wartungsarbeiten am Forum stattfinden. Vielen Dank für Ihre Geduld.',
			),
			'es' => array(
				'title'       => 'Sitio en mantenimiento',
				'subtitle'    => 'Estamos trabajando para mejorar el sitio',
				'description' => 'El sitio no está disponible temporalmente por mantenimiento programado. Volveremos a estar en línea muy pronto.',
				'footer'      => '¡Volveremos pronto!',
				'notice'      => 'Se informa a todos los usuarios de que del {START} al {END} se realizará un mantenimiento extraordinario del foro. Gracias por la paciencia.',
			),
			'pt' => array(
				'title'       => 'Site em manutenção',
				'subtitle'    => 'Estamos a trabalhar para melhorar o site',
				'description' => 'O site está temporariamente indisponível por manutenção programada. Voltaremos a estar online em breve.',
				'footer'      => 'Voltamos em breve!',
				'notice'      => 'Informamos todos os utilizadores de que de {START} a {END} decorrerá uma manutenção extraordinária do fórum. Obrigado pela paciência.',
			),
			'nl' => array(
				'title'       => 'Site in onderhoud',
				'subtitle'    => 'We werken aan verbeteringen van de site',
				'description' => 'De site is tijdelijk niet bereikbaar wegens gepland onderhoud. We zijn snel weer online.',
				'footer'      => 'Tot snel weer online!',
				'notice'      => 'Alle leden worden erop gewezen dat er van {START} tot {END} buitengewoon onderhoud aan het forum plaatsvindt. Dank voor het geduld.',
			),
			'pl' => array(
				'title'       => 'Trwa konserwacja',
				'subtitle'    => 'Pracujemy nad ulepszeniem serwisu',
				'description' => 'Serwis jest chwilowo niedostępny z powodu zaplanowanej konserwacji. Wkrótce wrócimy.',
				'footer'      => 'Wkrótce wracamy!',
				'notice'      => 'Informujemy wszystkich użytkowników, że od {START} do {END} odbędzie się nadzwyczajna konserwacja forum. Dziękujemy za cierpliwość.',
			),
			'ru' => array(
				'title'       => 'Сайт на обслуживании',
				'subtitle'    => 'Мы работаем над улучшением сайта',
				'description' => 'Сайт временно недоступен из-за планового обслуживания. Мы скоро вернёмся.',
				'footer'      => 'Скоро вернёмся!',
				'notice'      => 'Уведомляем всех пользователей, что с {START} по {END} будет проводиться внеплановое обслуживание форума. Спасибо за терпение.',
			),
			'tr' => array(
				'title'       => 'Site bakımda',
				'subtitle'    => 'Siteyi geliştirmek için çalışıyoruz',
				'description' => 'Site planlı bakım nedeniyle geçici olarak kullanılamıyor. Kısa süre içinde geri döneceğiz.',
				'footer'      => 'Yakında görüşmek üzere!',
				'notice'      => 'Tüm üyelerimize duyurulur: {START} ile {END} arasında forumda olağanüstü bakım yapılacaktır. Sabrınız için teşekkür ederiz.',
			),
			'el' => array(
				'title'       => 'Ο ιστότοπος συντηρείται',
				'subtitle'    => 'Εργαζόμαστε για τη βελτίωση του ιστότοπου',
				'description' => 'Ο ιστότοπος δεν είναι προσωρινά διαθέσιμος λόγω προγραμματισμένης συντήρησης. Επιστρέφουμε σύντομα.',
				'footer'      => 'Τα λέμε σύντομα!',
				'notice'      => 'Ενημερώνονται όλα τα μέλη ότι από {START} έως {END} θα γίνει έκτακτη συντήρηση του φόρουμ. Ευχαριστούμε για την υπομονή σας.',
			),
			'cs' => array(
				'title'       => 'Probíhá údržba',
				'subtitle'    => 'Pracujeme na vylepšení stránek',
				'description' => 'Stránky jsou dočasně nedostupné kvůli plánované údržbě. Brzy budeme zpět.',
				'footer'      => 'Brzy jsme zpět!',
				'notice'      => 'Upozorňujeme všechny uživatele, že od {START} do {END} proběhne mimořádná údržba fóra. Děkujeme za trpělivost.',
			),
			'ro' => array(
				'title'       => 'Site în mentenanță',
				'subtitle'    => 'Lucrăm la îmbunătățirea site-ului',
				'description' => 'Site-ul este temporar indisponibil din cauza unei mentenanțe programate. Revenim în curând.',
				'footer'      => 'Revenim în curând!',
				'notice'      => 'Îi informăm pe toți utilizatorii că între {START} și {END} va avea loc o mentenanță extraordinară a forumului. Vă mulțumim pentru răbdare.',
			),
			'sv' => array(
				'title'       => 'Underhåll pågår',
				'subtitle'    => 'Vi arbetar med att förbättra webbplatsen',
				'description' => 'Webbplatsen är tillfälligt otillgänglig på grund av planerat underhåll. Vi är snart tillbaka.',
				'footer'      => 'Vi ses snart igen!',
				'notice'      => 'Alla medlemmar informeras om att forumet genomgår extra underhåll från {START} till {END}. Tack för tålamodet.',
			),
			'hu' => array(
				'title'       => 'Karbantartás folyik',
				'subtitle'    => 'Az oldal fejlesztésén dolgozunk',
				'description' => 'Az oldal tervezett karbantartás miatt átmenetileg nem érhető el. Hamarosan visszatérünk.',
				'footer'      => 'Hamarosan visszatérünk!',
				'notice'      => 'Tájékoztatjuk a felhasználókat, hogy {START} és {END} között rendkívüli karbantartás lesz a fórumon. Köszönjük a türelmet.',
			),
			'ar' => array(
				'title'       => 'الموقع قيد الصيانة',
				'subtitle'    => 'نعمل على تحسين الموقع',
				'description' => 'الموقع غير متاح مؤقتاً بسبب صيانة مجدولة. سنعود قريباً.',
				'footer'      => 'سنعود قريباً!',
				'notice'      => 'نُعلم جميع الأعضاء بأنه ستُجرى صيانة استثنائية للمنتدى من {START} إلى {END}. شكراً لصبركم.',
			),
			'ja' => array(
				'title'       => 'ただいまメンテナンス中です',
				'subtitle'    => 'サイトの改善作業を行っています',
				'description' => '計画メンテナンスのため、一時的にご利用いただけません。まもなく再開します。',
				'footer'      => 'まもなく再開します。',
				'notice'      => '{START} から {END} まで、フォーラムの臨時メンテナンスを実施します。ご不便をおかけしますがご了承ください。',
			),
			'zh_cmn_hans' => array(
				'title'       => '网站维护中',
				'subtitle'    => '我们正在改进网站',
				'description' => '因计划维护，网站暂时无法访问。我们很快就会恢复。',
				'footer'      => '我们很快回来！',
				'notice'      => '谨此通知各位会员：论坛将于 {START} 至 {END} 进行临时维护。感谢您的耐心等待。',
			),
		);
	}

	/**
	 * Fixed interface strings of the maintenance page, per language.
	 */
	public static function ui_strings()
	{
		return array(
			'it' => array(
				'contact'      => 'Per informazioni urgenti, contattaci:',
				'admin_ask'    => 'Sei un amministratore?',
				'admin_btn'    => 'Accedi al Pannello Admin',
				'remaining'    => 'Tempo Rimanente',
				'start_label'  => 'Inizio Manutenzione',
				'end_label'    => 'Fine Stimata',
				'progress'     => 'Progresso Manutenzione',
				'ended'        => 'Manutenzione terminata, torniamo al forum...',
				'u_d'          => 'g',
				'u_h'          => 'h',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Anteprima',
				'admin_banner' => 'Manutenzione ATTIVA: gli utenti stanno vedendo la pagina di manutenzione. Tu vedi il forum normale perché sei amministratore. Per vedere la pagina come la vedono loro apri il forum in una finestra anonima, oppure attiva "Mostra la pagina anche agli amministratori" nel pannello.',
			),
			'en' => array(
				'contact'      => 'For urgent enquiries, contact us:',
				'admin_ask'    => 'Are you an administrator?',
				'admin_btn'    => 'Go to the Admin Panel',
				'remaining'    => 'Time Remaining',
				'start_label'  => 'Maintenance start',
				'end_label'    => 'Estimated end',
				'progress'     => 'Maintenance progress',
				'ended'        => 'Maintenance is over, taking you back to the board...',
				'u_d'          => 'd',
				'u_h'          => 'h',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Preview',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'fr' => array(
				'contact'      => 'Pour toute urgence, contactez-nous :',
				'admin_ask'    => 'Vous êtes administrateur ?',
				'admin_btn'    => 'Accéder au panneau d\'administration',
				'remaining'    => 'Temps restant',
				'start_label'  => 'Début de la maintenance',
				'end_label'    => 'Fin estimée',
				'progress'     => 'Progression de la maintenance',
				'ended'        => 'La maintenance est terminée, retour au forum...',
				'u_d'          => 'j',
				'u_h'          => 'h',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Aperçu',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'de' => array(
				'contact'      => 'Bei dringenden Fragen erreichen Sie uns hier:',
				'admin_ask'    => 'Sind Sie Administrator?',
				'admin_btn'    => 'Zum Administrationsbereich',
				'remaining'    => 'Verbleibende Zeit',
				'start_label'  => 'Beginn der Wartung',
				'end_label'    => 'Voraussichtliches Ende',
				'progress'     => 'Fortschritt der Wartung',
				'ended'        => 'Die Wartung ist beendet, zurück zum Forum...',
				'u_d'          => 'T',
				'u_h'          => 'Std',
				'u_m'          => 'Min',
				'u_s'          => 'Sek',
				'preview'      => 'Vorschau',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'es' => array(
				'contact'      => 'Para asuntos urgentes, contáctanos:',
				'admin_ask'    => '¿Eres administrador?',
				'admin_btn'    => 'Ir al panel de administración',
				'remaining'    => 'Tiempo restante',
				'start_label'  => 'Inicio del mantenimiento',
				'end_label'    => 'Fin estimado',
				'progress'     => 'Progreso del mantenimiento',
				'ended'        => 'El mantenimiento ha terminado, volvemos al foro...',
				'u_d'          => 'd',
				'u_h'          => 'h',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Vista previa',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'pt' => array(
				'contact'      => 'Para assuntos urgentes, contacte-nos:',
				'admin_ask'    => 'É administrador?',
				'admin_btn'    => 'Ir para o painel de administração',
				'remaining'    => 'Tempo restante',
				'start_label'  => 'Início da manutenção',
				'end_label'    => 'Fim estimado',
				'progress'     => 'Progresso da manutenção',
				'ended'        => 'A manutenção terminou, a regressar ao fórum...',
				'u_d'          => 'd',
				'u_h'          => 'h',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Pré-visualização',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'nl' => array(
				'contact'      => 'Voor dringende zaken kunt u ons bereiken:',
				'admin_ask'    => 'Bent u beheerder?',
				'admin_btn'    => 'Naar het beheerpaneel',
				'remaining'    => 'Resterende tijd',
				'start_label'  => 'Begin van het onderhoud',
				'end_label'    => 'Verwacht einde',
				'progress'     => 'Voortgang van het onderhoud',
				'ended'        => 'Het onderhoud is klaar, terug naar het forum...',
				'u_d'          => 'd',
				'u_h'          => 'u',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Voorbeeld',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'pl' => array(
				'contact'      => 'W pilnych sprawach prosimy o kontakt:',
				'admin_ask'    => 'Jesteś administratorem?',
				'admin_btn'    => 'Przejdź do panelu administracyjnego',
				'remaining'    => 'Pozostały czas',
				'start_label'  => 'Początek konserwacji',
				'end_label'    => 'Przewidywany koniec',
				'progress'     => 'Postęp konserwacji',
				'ended'        => 'Konserwacja zakończona, wracamy na forum...',
				'u_d'          => 'd',
				'u_h'          => 'godz',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Podgląd',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'ru' => array(
				'contact'      => 'По срочным вопросам пишите нам:',
				'admin_ask'    => 'Вы администратор?',
				'admin_btn'    => 'Перейти в панель управления',
				'remaining'    => 'Осталось времени',
				'start_label'  => 'Начало обслуживания',
				'end_label'    => 'Ожидаемое окончание',
				'progress'     => 'Ход обслуживания',
				'ended'        => 'Обслуживание завершено, возвращаемся на форум...',
				'u_d'          => 'д',
				'u_h'          => 'ч',
				'u_m'          => 'м',
				'u_s'          => 'с',
				'preview'      => 'Предпросмотр',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'tr' => array(
				'contact'      => 'Acil durumlar için bize ulaşın:',
				'admin_ask'    => 'Yönetici misiniz?',
				'admin_btn'    => 'Yönetim paneline git',
				'remaining'    => 'Kalan süre',
				'start_label'  => 'Bakımın başlangıcı',
				'end_label'    => 'Tahmini bitiş',
				'progress'     => 'Bakımın ilerleyişi',
				'ended'        => 'Bakım bitti, foruma dönülüyor...',
				'u_d'          => 'g',
				'u_h'          => 'sa',
				'u_m'          => 'dk',
				'u_s'          => 'sn',
				'preview'      => 'Önizleme',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'el' => array(
				'contact'      => 'Για επείγοντα θέματα επικοινωνήστε μαζί μας:',
				'admin_ask'    => 'Είστε διαχειριστής;',
				'admin_btn'    => 'Μετάβαση στον πίνακα διαχείρισης',
				'remaining'    => 'Χρόνος που απομένει',
				'start_label'  => 'Έναρξη συντήρησης',
				'end_label'    => 'Εκτιμώμενη λήξη',
				'progress'     => 'Πρόοδος συντήρησης',
				'ended'        => 'Η συντήρηση ολοκληρώθηκε, επιστροφή στο φόρουμ...',
				'u_d'          => 'η',
				'u_h'          => 'ώ',
				'u_m'          => 'λ',
				'u_s'          => 'δ',
				'preview'      => 'Προεπισκόπηση',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'cs' => array(
				'contact'      => 'V naléhavých případech nás kontaktujte:',
				'admin_ask'    => 'Jste správce?',
				'admin_btn'    => 'Přejít do administrace',
				'remaining'    => 'Zbývající čas',
				'start_label'  => 'Začátek údržby',
				'end_label'    => 'Předpokládaný konec',
				'progress'     => 'Průběh údržby',
				'ended'        => 'Údržba skončila, vracíme se na fórum...',
				'u_d'          => 'd',
				'u_h'          => 'h',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Náhled',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'ro' => array(
				'contact'      => 'Pentru urgențe, contactați-ne:',
				'admin_ask'    => 'Sunteți administrator?',
				'admin_btn'    => 'Mergi la panoul de administrare',
				'remaining'    => 'Timp rămas',
				'start_label'  => 'Începutul mentenanței',
				'end_label'    => 'Sfârșit estimat',
				'progress'     => 'Progresul mentenanței',
				'ended'        => 'Mentenanța s-a încheiat, revenim pe forum...',
				'u_d'          => 'z',
				'u_h'          => 'h',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Previzualizare',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'sv' => array(
				'contact'      => 'Vid brådskande ärenden, kontakta oss:',
				'admin_ask'    => 'Är du administratör?',
				'admin_btn'    => 'Gå till administrationen',
				'remaining'    => 'Återstående tid',
				'start_label'  => 'Underhållets början',
				'end_label'    => 'Beräknat slut',
				'progress'     => 'Underhållets förlopp',
				'ended'        => 'Underhållet är klart, vi återvänder till forumet...',
				'u_d'          => 'd',
				'u_h'          => 'tim',
				'u_m'          => 'm',
				'u_s'          => 's',
				'preview'      => 'Förhandsgranskning',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'hu' => array(
				'contact'      => 'Sürgős ügyben keressen minket:',
				'admin_ask'    => 'Ön adminisztrátor?',
				'admin_btn'    => 'Ugrás az adminisztrációhoz',
				'remaining'    => 'Hátralévő idő',
				'start_label'  => 'A karbantartás kezdete',
				'end_label'    => 'Várható befejezés',
				'progress'     => 'A karbantartás állása',
				'ended'        => 'A karbantartás véget ért, visszatérünk a fórumra...',
				'u_d'          => 'n',
				'u_h'          => 'ó',
				'u_m'          => 'p',
				'u_s'          => 'mp',
				'preview'      => 'Előnézet',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'ar' => array(
				'contact'      => 'للأمور العاجلة تواصلوا معنا:',
				'admin_ask'    => 'هل أنت مدير؟',
				'admin_btn'    => 'الانتقال إلى لوحة الإدارة',
				'remaining'    => 'الوقت المتبقي',
				'start_label'  => 'بداية الصيانة',
				'end_label'    => 'النهاية المتوقعة',
				'progress'     => 'تقدّم الصيانة',
				'ended'        => 'انتهت الصيانة، جارٍ العودة إلى المنتدى...',
				'u_d'          => 'ي',
				'u_h'          => 'س',
				'u_m'          => 'د',
				'u_s'          => 'ث',
				'preview'      => 'معاينة',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'ja' => array(
				'contact'      => 'お急ぎの場合はこちらまで：',
				'admin_ask'    => '管理者の方ですか？',
				'admin_btn'    => '管理パネルへ',
				'remaining'    => '残り時間',
				'start_label'  => 'メンテナンス開始',
				'end_label'    => '終了予定',
				'progress'     => 'メンテナンスの進捗',
				'ended'        => 'メンテナンスが終了しました。フォーラムに戻ります...',
				'u_d'          => '日',
				'u_h'          => '時間',
				'u_m'          => '分',
				'u_s'          => '秒',
				'preview'      => 'プレビュー',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
			'zh_cmn_hans' => array(
				'contact'      => '紧急事项请联系我们：',
				'admin_ask'    => '您是管理员吗？',
				'admin_btn'    => '进入管理面板',
				'remaining'    => '剩余时间',
				'start_label'  => '维护开始',
				'end_label'    => '预计结束',
				'progress'     => '维护进度',
				'ended'        => '维护已结束，正在返回论坛…',
				'u_d'          => '天',
				'u_h'          => '时',
				'u_m'          => '分',
				'u_s'          => '秒',
				'preview'      => '预览',
				'admin_banner' => 'Maintenance is ACTIVE: users are seeing the maintenance page. You see the normal board because you are an administrator. To see it as they do, open the board in a private window, or turn on "Show the page to administrators too" in the panel.',
			),
		);
	}


	/**
	 * Short label and full name of each language, for the switch on the page
	 * and for the lists in the settings panel.
	 */
	public static function lang_names()
	{
		return array(
			'it' => array('code' => 'IT', 'name' => 'Italiano'),
			'en' => array('code' => 'EN', 'name' => 'English'),
			'fr' => array('code' => 'FR', 'name' => 'Français'),
			'de' => array('code' => 'DE', 'name' => 'Deutsch'),
			'es' => array('code' => 'ES', 'name' => 'Español'),
			'pt' => array('code' => 'PT', 'name' => 'Português'),
			'nl' => array('code' => 'NL', 'name' => 'Nederlands'),
			'pl' => array('code' => 'PL', 'name' => 'Polski'),
			'ru' => array('code' => 'RU', 'name' => 'Русский'),
			'tr' => array('code' => 'TR', 'name' => 'Türkçe'),
			'el' => array('code' => 'EL', 'name' => 'Ελληνικά'),
			'cs' => array('code' => 'CS', 'name' => 'Čeština'),
			'ro' => array('code' => 'RO', 'name' => 'Română'),
			'sv' => array('code' => 'SV', 'name' => 'Svenska'),
			'hu' => array('code' => 'HU', 'name' => 'Magyar'),
			'ar' => array('code' => 'AR', 'name' => 'العربية'),
			'ja' => array('code' => 'JA', 'name' => '日本語'),
			'zh_cmn_hans' => array('code' => 'ZH', 'name' => '中文'),
		);
	}

/**
	 * Editable texts merged with the built in ones.
	 *
	 * Every language is guaranteed to carry every field: a stored value is used
	 * only when it exists and is not empty, so a partial or outdated saved set
	 * can never leave a hole for the caller to trip over.
	 */
	public function get_messages()
	{
		$stored = json_decode((string) $this->config_text->get('agm_messages'), true);
		$stored = is_array($stored) ? $stored : array();

		$messages = self::default_messages();

		foreach ($messages as $lang => $fields)
		{
			foreach ($fields as $key => $value)
			{
				if (isset($stored[$lang][$key]) && $stored[$lang][$key] !== '')
				{
					$messages[$lang][$key] = (string) $stored[$lang][$key];
				}
			}
		}

		return $messages;
	}

	/**
	 * Store the admin editable texts.
	 */
	public function set_messages(array $messages)
	{
		$clean = array();

		foreach (self::default_messages() as $lang => $fields)
		{
			foreach ($fields as $key => $default)
			{
				$clean[$lang][$key] = isset($messages[$lang][$key]) ? (string) $messages[$lang][$key] : $default;
			}
		}

		$this->config_text->set('agm_messages', json_encode($clean));
	}

	/**
	 * Colour palette, with fallbacks matching the default theme.
	 */
	public function get_colors()
	{
		$defaults = array(
			'agm_color_bg_start' => '#0f1c3f',
			'agm_color_bg_end'   => '#1d4ed8',
			'agm_color_topbar'   => '#0b1120',
			'agm_color_accent'   => '#3b82f6',
			'agm_color_text'     => '#f8fafc',
			'agm_color_muted'    => '#c7d2fe',
			'agm_color_card'     => '#16255180',
			'agm_color_cd_from'  => '#2b3f8fcc',
			'agm_color_cd_to'    => '#5b3a8fcc',
			'agm_color_prog_a'   => '#60a5fa',
			'agm_color_prog_b'   => '#c084fc',
		);

		$colors = array();

		foreach ($defaults as $key => $default)
		{
			$value = isset($this->config[$key]) ? trim((string) $this->config[$key]) : '';
			$colors[$key] = preg_match('/^#[0-9a-fA-F]{3,8}$/', $value) ? $value : $default;
		}

		return $colors;
	}

	/**
	 * Maintenance switch (the ACP radio button).
	 */
	public function is_enabled()
	{
		return !empty($this->config['agm_enabled']);
	}

	public function get_start()
	{
		return (int) (isset($this->config['agm_start']) ? $this->config['agm_start'] : 0);
	}

	public function get_end()
	{
		return (int) (isset($this->config['agm_end']) ? $this->config['agm_end'] : 0);
	}

	/**
	 * Should the advance notice be shown right now?
	 *
	 * It only makes sense with a schedule: the switch must be on, a start and
	 * an end date must be set, and the window must not have begun yet. Once
	 * maintenance is running the visitor sees the full page instead.
	 *
	 * @return array empty when nothing should be shown
	 */
	public function get_notice()
	{
		if (empty($this->config['agm_notice']) || !$this->is_enabled() || empty($this->config['agm_use_schedule']))
		{
			return array();
		}

		$start = $this->get_start();
		$end   = $this->get_end();
		$now   = time();

		if (!$start || !$end || $now >= $start)
		{
			return array();
		}

		// Optional lead time: show it only in the days before the window
		$days = (int) $this->config['agm_notice_days'];

		if ($days > 0 && $start - $now > $days * 86400)
		{
			return array();
		}

		$messages = $this->get_messages();
		$lang     = $this->current_lang();
		$template = isset($messages[$lang]['notice']) ? $messages[$lang]['notice'] : '';

		if (trim($template) === '')
		{
			return array();
		}

		return array(
			'template' => str_replace('{SITENAME}', (string) $this->config['sitename'], $template),
			'start'    => $start,
			'end'      => $end,
		);
	}

	/**
	 * Put the advance notice on the current page.
	 *
	 * The text is split around the {START} and {END} placeholders and passed as
	 * template blocks. Each date carries its UNIX timestamp so the browser can
	 * print it in the reader's own timezone, exactly like the countdown card
	 * does: formatting it here would use the account timezone instead, which is
	 * what made the times look shifted.
	 */
	public function assign_notice()
	{
		$notice = $this->get_notice();

		if (empty($notice))
		{
			return;
		}

		$parts = preg_split('/(\{START\}|\{END\})/', $notice['template'], -1, PREG_SPLIT_DELIM_CAPTURE);

		foreach ($parts as $part)
		{
			if ($part === '')
			{
				continue;
			}

			if ($part === '{START}' || $part === '{END}')
			{
				$stamp = ($part === '{START}') ? $notice['start'] : $notice['end'];

				$this->template->assign_block_vars('agm_notice_part', array(
					'TEXT' => $this->user->format_date($stamp, 'd/m/Y H:i'),
					'TS'   => $stamp,
				));
			}
			else
			{
				$this->template->assign_block_vars('agm_notice_part', array(
					'TEXT' => $part,
					'TS'   => 0,
				));
			}
		}

		$this->template->assign_var('S_AGM_NOTICE', true);
	}

	/**
	 * Tell an administrator why they are looking at the ordinary board while
	 * maintenance is running.
	 *
	 * phpBB shows its own red "board disabled" line to admins, which reads like
	 * a fault; this says plainly that the extension is working and that other
	 * visitors are getting the maintenance page.
	 */
	public function assign_admin_banner()
	{
		if (!$this->is_active() || $this->show_to_admins())
		{
			return;
		}

		if (!$this->auth->acl_get('a_') && (!isset($this->user->data['user_type']) || (int) $this->user->data['user_type'] !== USER_FOUNDER))
		{
			return;
		}

		$strings = self::ui_strings();
		$lang    = $this->current_lang();

		$this->template->assign_vars(array(
			'S_AGM_ADMIN_BANNER' => true,
			'AGM_ADMIN_BANNER'   => isset($strings[$lang]['admin_banner'])
				? $strings[$lang]['admin_banner']
				: $strings['en']['admin_banner'],
		));
	}

	/**
	 * Is the maintenance page to be shown right now?
	 *
	 * The switch must be on and, when a schedule is set, the current time must
	 * fall inside the window. Once the end date has passed the switch is turned
	 * off automatically.
	 */
	public function is_active()
	{
		if (!$this->is_enabled())
		{
			return false;
		}

		if (empty($this->config['agm_use_schedule']))
		{
			return true;
		}

		$now   = time();
		$start = $this->get_start();
		$end   = $this->get_end();

		if ($start && $now < $start)
		{
			return false;
		}

		if ($end && $now > $end)
		{
			if (!empty($this->config['agm_auto_off']))
			{
				$this->deactivate();
			}

			return false;
		}

		return true;
	}

	/**
	 * Turn maintenance on and write the activation log.
	 */
	public function activate()
	{
		$this->config->set('agm_enabled', 1);
		$this->config->set('agm_last_on', time());
		$this->config->increment('agm_total_activations', 1);

		// Do not touch phpBB's switch here: sync_board_disable() follows the
		// real state, so a window scheduled for later leaves the board open.
		$this->sync_board_disable($this->is_active());
	}

	public function deactivate()
	{
		$this->config->set('agm_enabled', 0);
		$this->config->set('agm_last_off', time());

		$this->sync_board_disable(false);
	}

	/**
	 * Keep phpBB's own "Disable board" setting in step with whether the
	 * maintenance page is actually showing.
	 *
	 * A "governed" flag records whether the board was closed by us. The
	 * previous value is captured only when we take control and is given back
	 * only when we release it. Without that flag, closing the board twice in a
	 * row would record "already closed" as the value to restore, and the board
	 * would stay shut for good behind phpBB's own notice.
	 */
	public function sync_board_disable($active)
	{
		if (empty($this->config['agm_sync_board_disable']))
		{
			return;
		}

		$governed = !empty($this->config['agm_board_governed']);
		$current  = (int) $this->config['board_disable'];

		if ($active)
		{
			if (!$governed)
			{
				// Taking control: remember how the admin had left it
				$this->config->set('agm_prev_board_disable', $current);
				$this->config->set('agm_board_governed', 1);
			}

			if ($current !== 1)
			{
				$this->config->set('board_disable', 1);
			}

			return;
		}

		if (!$governed)
		{
			// Not ours to restore, leave the admin's own setting alone
			return;
		}

		$previous = (int) $this->config['agm_prev_board_disable'];

		if ($current !== $previous)
		{
			$this->config->set('board_disable', $previous);
		}

		$this->config->set('agm_board_governed', 0);
	}

	/**
	 * Should administrators see the maintenance page as well?
	 * The ACP always stays reachable either way.
	 */
	public function show_to_admins()
	{
		return !empty($this->config['agm_show_to_admins']);
	}

	/**
	 * Turn maintenance off and write the activation log.
	 */
	/**
	 * Language used for the first paint of the maintenance page.
	 */
	public function current_lang()
	{
		$requested = strtolower($this->request->variable('agm_lang', ''));

		if (in_array($requested, self::LANGS, true))
		{
			return $requested;
		}

		$board = strtolower((string) (isset($this->user->lang_name) ? $this->user->lang_name : ''));

		// The board pack may be named exactly like ours (zh_cmn_hans), or be a
		// regional variant of it (pt_br, de_x_sie): try the whole name first,
		// then the part before the underscore.
		if ($board !== '')
		{
			if (in_array($board, self::LANGS, true))
			{
				return $board;
			}

			$short = substr($board, 0, 2);

			if (in_array($short, self::LANGS, true))
			{
				return $short;
			}
		}

		$fallback = (string) $this->config['agm_default_lang'];

		return in_array($fallback, self::LANGS, true) ? $fallback : 'en';
	}

	/**
	 * Build the full HTML of the maintenance page.
	 *
	 * @param bool $preview     true when rendered from the ACP preview
	 * @param bool $init_style  true when the template engine still needs a style
	 * @return string
	 */
	public function render($preview = false, $init_style = false)
	{
		if ($init_style)
		{
			$this->template->set_style();
		}

		$messages = $this->get_messages();
		$ui       = self::ui_strings();
		$colors   = $this->get_colors();
		$lang     = $this->current_lang();

		$payload = array();

		foreach (self::LANGS as $iso)
		{
			$payload[$iso] = array_merge($messages[$iso], $ui[$iso]);
		}

		$board_url = generate_board_url();
		$start     = $this->get_start();
		$end       = $this->get_end();

		$this->template->assign_vars(array(
			'AGM_PREVIEW'       => (bool) $preview,
			'AGM_LANG'          => $lang,
			'AGM_MESSAGES_JSON' => json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE),

			'AGM_SITENAME'      => $this->config['sitename'],
			'AGM_INITIALS'      => $this->initials((string) $this->config['sitename']),
			//'AGM_LOGO_URL'      => trim((string) $this->config['agm_logo_url']),
			'AGM_LOGO_URL'      => $this->logo_url($board_url),

			'AGM_TITLE'         => $payload[$lang]['title'],
			'AGM_SUBTITLE'      => $payload[$lang]['subtitle'],
			'AGM_DESCRIPTION'   => $payload[$lang]['description'],
			'AGM_FOOTER_TEXT'   => $payload[$lang]['footer'],
			'AGM_CONTACT_LABEL' => $payload[$lang]['contact'],
			'AGM_ADMIN_ASK'     => $payload[$lang]['admin_ask'],
			'AGM_ADMIN_BTN'     => $payload[$lang]['admin_btn'],
			'AGM_PREVIEW_LABEL' => $payload[$lang]['preview'],
			'AGM_L_REMAINING'   => $payload[$lang]['remaining'],
			'AGM_L_START'       => $payload[$lang]['start_label'],
			'AGM_L_END'         => $payload[$lang]['end_label'],
			'AGM_L_PROGRESS'    => $payload[$lang]['progress'],

			'AGM_EMAIL'         => trim((string) $this->config['agm_contact_email']),
			'AGM_PHONE'         => trim((string) $this->config['agm_contact_phone']),
			'AGM_SHOW_CONTACT'  => (trim((string) $this->config['agm_contact_email']) !== '' || trim((string) $this->config['agm_contact_phone']) !== ''),

			'AGM_SHOW_PARTICLES' => !empty($this->config['agm_particles']),
			'AGM_SHOW_GEAR'      => !empty($this->config['agm_show_gear']),
			'AGM_SPIN_GEAR'      => !empty($this->config['agm_spin_gear']),
			'AGM_SHOW_COUNTDOWN' => (!empty($this->config['agm_countdown']) && $end > 0),
			'AGM_SHOW_LANGS'     => !empty($this->config['agm_lang_switcher']),
			'AGM_SHOW_ADMIN'     => !empty($this->config['agm_show_admin_link']),
			'AGM_AUTO_REFRESH'   => (int) $this->config['agm_refresh'],

			'AGM_SHOW_DATES'     => (!empty($this->config['agm_show_dates']) && ($start > 0 || $end > 0)),
			'AGM_SHOW_PROGRESS'  => (!empty($this->config['agm_progress_bar']) && $start > 0 && $end > $start),

			'AGM_START_TS'       => $start,
			'AGM_END_TS'         => $end,
			'AGM_NOW_TS'         => time(),
			'AGM_START_HUMAN'    => $start ? $this->user->format_date($start, 'd/m/Y H:i') : '—',
			'AGM_END_HUMAN'      => $end ? $this->user->format_date($end, 'd/m/Y H:i') : '—',

			'U_AGM_INDEX'        => append_sid($board_url . '/index.' . $this->php_ext),

			// phpBB refuses a bare adm/index.php with a 401: its own footer link
			// carries the session id, so this one has to as well. Visitors who
			// are not signed in go to the login form instead.
			'U_AGM_ADMIN'        => $this->auth->acl_get('a_') && !empty($this->user->data['is_registered'])
				? append_sid($board_url . '/' . $this->adm_path . 'index.' . $this->php_ext, false, true, $this->user->session_id)
				: append_sid($board_url . '/ucp.' . $this->php_ext, 'mode=login'),

			'AGM_C_BG_START'     => $colors['agm_color_bg_start'],
			'AGM_C_BG_END'       => $colors['agm_color_bg_end'],
			'AGM_C_TOPBAR'       => $colors['agm_color_topbar'],
			'AGM_C_ACCENT'       => $colors['agm_color_accent'],
			'AGM_C_TEXT'         => $colors['agm_color_text'],
			'AGM_C_MUTED'        => $colors['agm_color_muted'],
			'AGM_C_CARD'         => $colors['agm_color_card'],
			'AGM_C_CD_FROM'      => $colors['agm_color_cd_from'],
			'AGM_C_CD_TO'        => $colors['agm_color_cd_to'],
			'AGM_C_PROG_A'       => $colors['agm_color_prog_a'],
			'AGM_C_PROG_B'       => $colors['agm_color_prog_b'],
		));

		// One button per language on the switch, in a fixed order
		$names = self::lang_names();

		foreach (self::LANGS as $iso)
		{
			$this->template->assign_block_vars('agm_language', array(
				'ISO'      => $iso,
				'CODE'     => $names[$iso]['code'],
				'NAME'     => $names[$iso]['name'],
				'S_ACTIVE' => ($iso === $lang),
			));
		}

		$this->template->set_filenames(array(
			'agm_body' => '@salvocortesiano_maintenance/maintenance_page.html',
		));

		return $this->template->assign_display('agm_body');
	}

	/**
	 * Send the maintenance page and stop the request.
	 */
	public function render_and_exit()
	{
		$html = $this->render(false, true);

		if (!headers_sent())
		{
			header('HTTP/1.1 503 Service Unavailable');
			header('Status: 503 Service Unavailable');
			header('Content-Type: text/html; charset=UTF-8');
			header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
			header('Pragma: no-cache');
			header('Expires: 0');

			$end = $this->get_end();

			if ($end > time())
			{
				header('Retry-After: ' . ($end - time()));
			}
		}

		echo $html;

		garbage_collection();
		exit_handler();
	}

	/**
	 * Absolute URL of the logo.
	 *
	 * A relative path such as "images/logo.png" would be resolved against
	 * app.php/maintenance/preview when the page is previewed, which points
	 * nowhere. Anchoring it to the board URL makes it work from any address.
	 * Spaces and other unsafe characters in the file name are encoded too.
	 */
	protected function logo_url($board_url)
	{
		$logo = trim((string) $this->config['agm_logo_url']);

		if ($logo === '')
		{
			return '';
		}

		// Already absolute, or protocol relative: leave it alone
		if (preg_match('#^(https?:)?//#i', $logo) || strpos($logo, 'data:') === 0)
		{
			return $logo;
		}

		$logo = ltrim($logo, '/');
		$parts = explode('/', $logo);

		foreach ($parts as $i => $part)
		{
			$parts[$i] = rawurlencode($part);
		}

		return $board_url . '/' . implode('/', $parts);
	}

	/**
	 * Up to two initials used by the logo badge.
	 */
	protected function initials($name)
	{
		$parts = preg_split('/\s+/', trim($name), -1, PREG_SPLIT_NO_EMPTY);

		if (empty($parts))
		{
			return 'AG';
		}

		$out = utf8_substr($parts[0], 0, 1);

		if (isset($parts[1]))
		{
			$out .= utf8_substr($parts[1], 0, 1);
		}

		return utf8_strtoupper($out);
	}
}
