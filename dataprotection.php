<?php include_once("backend/auth/google_auth.php"); ?>
<html lang="de">
<head>
  <title>MTG Companion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
  <link href="style/mtgcompanion.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-sm static-top navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">MTG Companion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="randomizer.php" role="button" data-bs-toggle="dropdown">Challange</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="information.php">Informationen</a></li>
                            <li><a class="dropdown-item" href="randomizer.php">Challange Randomizer</a></li>
                            <li><a class="dropdown-item" href="upgrade.php">Preis Checker</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="trading.php">Trade-Hub</a>
                    </li>
                </ul>
                <?php if(!isset($_SESSION['id'])) { ?>
                <a class="google-sign-in" href="<?php echo $client->createAuthUrl(); ?>">
                    <div>
                        <i class="fa-brands fa-google"></i>Google Login
                    </div>
                </a>
                <?php } else { ?>
                <div class="logout">
                    Hallo <?php echo $_SESSION['name']; ?>!
                    <a href="backend/auth/logout.php?site=trading.php"><i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container mx-auto mt-auto p-0 m-5">
        <h3 class="mt-5">Datenschutzerklärung</h3>
        <h5>Lukas Roth</h5>
        <div>Quartiersweg 2, 10829 Berlin</div>
        <div>Der Schutz Ihrer persönlichen Daten ist uns ein besonderes Anliegen.</div>
        <div>Wir verarbeiten Ihre Daten daher ausschließlich auf Grundlage der gesetzlichen Bestimmungen (DSGVO, TKG 2003). In diesen Datenschutzinformationen informieren wir Sie über die wichtigsten Aspekte der Datenverarbeitung im Rahmen unserer Website.</div>
        <h5 class="mt-3">Verantwortlicher</h5>
        <div>Verantwortlicher für die Datenverarbeitung ist die Person Lukas Roth mit Sitz in Quartiersweg 2, 10829 Berlin. Sie erreichen uns per Mail unter admin@firephenix.de oder postalisch unter der Anschrift Quartiersweg 2, 10829 Berlin.</div>
        <h5 class="mt-3">Datensicherheit</h5>
        <div>Wir treffen nach Maß des Art 32 DSGVO entsprechende Vorkehrungen zum Schutz Ihrer personenbezogenen Daten. Diese betreffen insbesondere den Schutz vor unerlaubtem, rechtswidrigem oder auch zufälligem Zugriff, Verarbeitung, Verlust, Verwendung und Manipulation.</div>
        <h4 class="mt-3">Webseite</h4>
        <h5 class="mt-3">Personenbezogene Daten, Zweck der Datenverarbeitung und Rechtsgrundlage</h5>
        <div>Personenbezogene Daten sind Angaben, die eindeutig einer Person zugeordnet werden können. Dazu gehören unter anderem Angaben wie vollständiger Name, Anschrift, E-Mail und Telefonnummer. Bei einem Besuch unserer Website werden aus technischen Gründen automatisch weitere Daten erfasst (IP-Adresse, Beginn und Ende der Sitzung, Datum und Uhrzeit der Anfrage, angesteuerte Unterseite auf unserer Webseite, Art und Version des Browsers, Betriebssystem, Referrer URL). Diese technischen Informationen können im Einzelfall personenbezogene Daten sein. Im Regelfall verwenden wir diese technischen Informationen nur, wenn dies (aus technischen Gründen) für den Betrieb und Schutz unserer Website vor Angriffen und Missbrauch erforderlich ist sowie pseudonymisiert oder anonymisiert für statistische Zwecke.</div>
        <div>Wenn Sie per Anfrageformular auf der Website oder per E-Mail Kontakt mit uns aufnehmen, werden Ihre angegebenen Daten (Vorname, Nachname, Adresse, Telefonnummer, E-Mail) zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen sechs Monate bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter. Eine Verarbeitung Ihrer personenbezogenen Daten für bestimmte Zwecke (z. B. Nutzung Ihrer E-Mail für Newsletter, Werbung) kann auch aufgrund Ihrer Einwilligung erfolgen. Sie können Ihre Einwilligung mit Wirkung für die Zukunft jederzeit widerrufen. Dies gilt auch für den Widerruf von Einwilligungserklärungen, die vor der Geltung der DSGVO, uns gegenüber erteilt worden sind. Über die Zwecke und über die Konsequenzen eines Widerrufs oder der Nichterteilung einer Einwilligung werden Sie gesondert im entsprechenden Text der Einwilligung informiert.</div>
        <div>Zur Erfüllung von Verträgen bzw. vorvertragliche Maßnahmen und darüber hinaus verarbeiten wir Ihre Daten (Vorname, Nachname, Adresse, Telefonnummer, E-Mail) gegebenenfalls, wenn es erforderlich ist, um berechtigte Interessen von uns oder Dritten zu wahren, insbesondere für folgende Zwecke:</div>
        <ul>
            <li>Beantwortung von Anfragen</li>
            <li>Technische Administration</li>
            <li>der Werbung oder Markt- und Meinungsforschung, soweit Sie der Nutzung Ihrer Daten nicht widersprochen haben</li>
            <li>der Prüfung und Optimierung von Verfahren zur Bedarfsanalyse</li>
            <li>der Weiterentwicklung von Dienstleistungen und Produkten sowie bestehenden Systemen und Prozessen</li>
            <li>statistischer Auswertungen oder der Marktanalyse</li>
            <li>der Geltendmachung rechtlicher Ansprüche & Verteidigung bei rechtlichen Streitigkeiten, die nicht unmittelbar dem Vertragsverhältnis zuzuordnen sind</li>
            <li>der Verhinderung und Aufklärung von Straftaten, soweit nicht ausschließlich zur Erfüllung gesetzlicher Vorgaben</li>
        </ul>
        <div>Die Rechtsgrundlagen der Datenverarbeitung sind:</div>
        <ul>
            <li>Vertragsabwicklung gemäß Art 6 Abs 1 lit b DSGVO</li>
            <li>Ihre allfällige Einwilligung gemäß Art 6 Abs 1 lit a DSGVO</li>
            <li>berechtigtes Interesse Art 6 Abs 1 lit f DSGVO</li>
        </ul>
        <h5 class="mt-3">Speicherdauer</h5>
        <div>Die Löschung der gespeicherten personenbezogenen Daten erfolgt, wenn Sie als Nutzer unserer Website und/oder Kunde die Einwilligung zur Speicherung widerrufen, wenn Ihre Daten zur Erfüllung des mit der Speicherung verfolgten Zwecks nicht mehr erforderlich sind und nach Ablauf der gesetzlichen Aufbewahrungspflichten bzw. nach Ablauf der Dauer allfälliger darüber hinaus andauernden Rechtsstreitigkeiten oder wenn Ihre Speicherung aus sonstigen gesetzlichen Gründen unzulässig ist bzw. wird.</div>
        <h5 class="mt-3">Weitergabe von Daten / Empfänger bzw. Kategorien von Empfängern</h5>
        <div>Eine Weitergabe Ihrer Daten an externe Stellen erfolgt ausschließlich im Zusammenhang mit der Vertragsabwicklung, zu Zwecken der Erfüllung gesetzlicher Vorgaben, nach denen wir zur Auskunft, Meldung oder Weitergabe von Daten verpflichtet sind oder sofern die Datenweitergabe im öffentlichen Interesse liegt oder Sie zuvor eingewilligt haben. Sie haben das Recht, eine erteilte Einwilligung mit Wirkung auf die Zukunft jederzeit zu widerrufen.</div>
        <div>Personenbezogene Daten werden von uns an die nachfolgend bezeichneten Dritten weitergegeben bzw. übermittelt:</div>
        <ul>
            <li>Verschiedene Dienstleister oder Partnerunternehmen, die uns bei der Bestellabwicklung, bei der Versorgung der Kunden mit Informationen, Werbung und bei der Bereitstellung von Dienstleistungen unterstützen, EDV Dienstleister und technische Verarbeiter (Auftragsverarbeiter gemäß Art. 28 DS-GVO). Diese Unternehmen sind verpflichtet, sämtliche Datenschutzbestimmungen einzuhalten. Für die Auftragsdatenverarbeitung gelten strenge datenschutzrechtliche Vorschriften, insbesondere dürfen diese Unternehmen die Daten ausschließlich zur Erfüllung ihrer Aufgaben in unserem Auftrag nutzen. Für die Einhaltung der datenschutzrechtlichen Vorschriften durch diese Unternehmen sind wir verantwortlich und haben wir entsprechende Auftragsverarbeitungsvereinbarungen mit den Dienstleistern geschlossen</li>
            <li>an unseren Steuerberater zur Erfüllung unserer steuerrechtlichen Verpflichtungen</li>
        </ul>
        <h5 class="mt-3">Verwendung von Google Fonts</h5>
        <div>Auf unserer Website und zur Ergänzung unsere Onlineangebotes setzen wir den Drittanbieterdienst Google Fonts ein. Dies tun wir auf Basis unserer berechtigten Interessen (Art 6 Abs 1 lit f DSGVO), z.B. unserem Interesse an der Optimierung und dem wirtschaftlichen Betrieb unserer Onlineangebote. Diesr Dienst setzen voraus, dass die die IP-Adresse der Website-Besucher wahrgenommen wird. Ohne die IP-Adresse könnten die bezogenen Inhalte nicht an ihren Browser gesendet werden.</div>
        <div>Anbieter ist die Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA. Deren Datenschutzrichtlinien finden Sie hier: www.google.com/policies/privacy/. Ein Opt-out wäre hier möglich: https://adssettings.google.com/authenticated</div>
        <h5 class="mt-3">Google OAuth 2.0</h5>
        <div>Wir erlauben Nutzern, sich auf unserer Website mit ihrem Google-Account anzumelden. Dafür nutzen wir Google OAuth 2.0, welches eine API-Authorisierung durch den Nutzer möglich macht, ohne dass wir die Zugangsdaten des Nutzers erhalten. Durch die Anmeldung über das Google OAuth 2.0 Verfahren und anschließende Bestätigung des Zugriffes im OAuth-Zustimmungsbildschirm können personenbezogene Daten von Google an uns und von uns an Google gesendet werden. Damit sind Informationen wie IP-Adresse, genutzer Browser etc. gemeint und keine privaten Daten wie Klarname oder Anschriften. Informationen dazu, welche Daten Google erhebt und wie Google mit diesen Daten verfährt, ist der diesbezogenen Datenschutzerklärung von Google zu entnehmen (https://policies.google.com/technologies/partner-sites?hl=de).
            Durch Nutzen der Google OAuth 2.0 Funktion auf einer unserer Website stimmt der Nutzer der Verwendung explizit zu. Die Autorisierung der API Anfragen findet demnach ausschließlich statt, wenn sich der Nutzer aktiv dazu entscheiden, diese Daten über das Google OAuth 2.0 Verfahren mit uns zu teilen und zuvor über alle notwendigen Informationen zur Verarbeitung dieser informiert wurden und den Erhalt dieser Information bestätigt haben. Rechtsgrundlage in diesem Fall ist die Einwilligung der Influencer nach Art. 6 Abs. 1 S. 1 lit. a DSGVO.</div>
        <h5 class="mt-3">Ihre Rechte</h5>
        <div>Ihnen stehen grundsätzlich die Rechte auf Auskunft, Berichtigung, Löschung, Einschränkung, Datenübertragbarkeit, Widerruf und Widerspruch zu.</div>
        <div>Wenn Sie glauben, dass die Verarbeitung Ihrer Daten gegen das Datenschutzrecht verstößt oder Ihre datenschutzrechtlichen Ansprüche sonst in einer Weise verletzt worden sind, können Sie sich bei uns admin@firephenix.de oder der Datenschutzbehörde beschweren.</div>
    </div>
    <div class="container mt-auto">
        <footer class="py-3 my-4">
          <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="impressum.php" class="nav-link px-2 text-muted">Impressum</a></li>
            <li class="nav-item"><a href="dataprotection.php" class="nav-link px-2 text-muted">Datenschutz</a></li>
          </ul>
          <p class="text-center text-muted">MTG Companion is unofficial Fan Content permitted under the Fan Content Policy. Not approved/endorsed by Wizards. Portions of the materials used are property of Wizards of the Coast. ©Wizards of the Coast LLC.</p>
        </footer>
    </div>
</body>
</html>