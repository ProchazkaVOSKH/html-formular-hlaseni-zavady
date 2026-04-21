<?php
header('Content-Type: text/html; charset=utf-8');

function renderValue($value): string
{
    if (is_array($value)) {
        return implode(', ', array_map('htmlspecialchars', $value));
    }

    return htmlspecialchars((string) $value);
}

function renderRow(string $key, string $label): string
{
    $hasValue = !empty($_POST[$key]);
    $value = $hasValue ? renderValue($_POST[$key]) : '—';
    $statusClass = $hasValue ? 'w3-text-green' : 'w3-text-red';
    $statusText = $hasValue ? '✅ OK' : '❌ Chybí';

    return "
        <tr>
            <td>{$label} <code>({$key})</code></td>
            <td>{$value}</td>
            <td class=\"{$statusClass}\"><b>{$statusText}</b></td>
        </tr>";
}

$items = [
    'jmeno' => 'Jméno',
    'email' => 'E-mail',
    'mistnost' => 'Místnost',
    'priorita' => 'Priorita',
    'zavady' => 'Typ závady',
    'popis' => 'Popis',
];
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontrola přijatých dat</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-light-grey">

    <main class="w3-container w3-section">
        <section class="w3-content">
            <article class="w3-card w3-white w3-padding-large">
                <header class="w3-margin-bottom">
                    <h1 class="w3-text-blue">🖥️ Kontrola přijatých dat z formuláře</h1>
                    <p class="w3-text-grey">Přehled odeslaných hodnot a základní kontrola vyplnění.</p>
                </header>

                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                    <div class="w3-responsive">
                        <table class="w3-table-all w3-hoverable">
                            <thead>
                                <tr class="w3-dark-grey">
                                    <th>Pole (atribut <code>name</code>)</th>
                                    <th>Hodnota</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $name => $label) : ?>
                                    <?= renderRow($name, $label); ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <p class="w3-margin-top">
                        <a class="w3-button w3-blue" href="javascript:history.back()">← Zpět k formuláři</a>
                    </p>
                <?php else : ?>
                    <div class="w3-panel w3-pale-red w3-leftbar w3-border-red">
                        <h3>Formulář nebyl odeslán správně</h3>
                        <p>Zkontrolujte, že formulář používá <code>method="post"</code> a byl odeslán z formuláře <code>index.html</code>.</p>
                    </div>
                    <p>
                        <a class="w3-button w3-blue" href="index.html">← Zpět na formulář</a>
                    </p>
                <?php endif; ?>
            </article>
        </section>
    </main>

</body>
</html>