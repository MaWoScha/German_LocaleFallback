# German_LocaleFallback
Dieses Paket zur Unterstützung von Sprachpaketen wird von MaWoScha verwaltet.

This package for supporting LocalePack is managed by [MaWoScha](https://github.com/MaWoScha).

# Use
Add support for a fallback language.

Usecase: You have in the LocalePack_de_DE and LocalePack_de_CH, nearly everything is the same but
a few are not, so if you don't find a phrase in de_CH look it up in the fallback, de_DE.

Fügt die Unterstützung einer Ausweichsprache hinzu.

Anwendungsfall: Sie haben in den LocalePack_de_DE und LocalePack_de_CH, fast alles ist gleich, aber einige Einträge
sind es nicht; wenn Sie also einen Eintrag in de_CH nicht finden, schauen Sie in die Ausfallmöglichkeit de_DE.

# More info

* http://www.integer-net.de/magento-at-landerversion-mit-fallback-modus-fur-ubersetzungen/ (German)
* http://blog.siempro.co/?p=105&lang=en (English, German, Spanish)

# Version history

v0.1.0

No so much functionality yet, but a framework is done.

v0.2.0

The work of [Hackathon LocaleFallback](https://github.com/magento-hackathon/Hackathon_LocaleFallback) integrated

v0.3.0

Add some configuration stuff.

Now you can individually expand the list of locales and fallbacks.

Einige Einstellmöglichkeiten wurden ergänzt.

Nun können Sie individuell die Liste der Sprachumgebungen und Ausweichsprachen erweitern.

v0.4.0

The fallback locale has now also effect on email templates.

Die Ausweichsprache greift nun auch bei den E-Mail-Vorlagen.

v0.4.1

Fix incorrect loading of theme translation. Sets the global locale to fallback locale to be able to retrieve the correct path to the themes translate.csv in Mage_Core_Model_Design_Package::getLocaleBaseDir()

Provided by [access3000] (https://github.com/access3000/Hackathon_LocaleFallback/commit/b011bf1e0ea60341c7fe685c37ce4d65545aa842)

v0.4.2

Small fix in "etc/system.xml"

Prevent locale fallback in backend, provided by [diglin] (https://github.com/diglin/German_LocaleFallback/commit/0a8421bcc4a1910adeec18f1987596429c5fb7a0)

v0.4.3

Die Datei
* var/package/Delete_EmailTemplates_en_US-1.0.0.xml
erlaubt die vorinstallierten englischsprachigen E-Mail-Vorlagen über den "Magento Connect Manager" zu löschen und
*  [German LocalePack en_US](https://github.com/MaWoScha/German_LocalePack_en_US)
ohne Rückgriff auf FTP oder Dateimanager zu installieren.

Fix issue with string expected but object is return from getlocale, provided by [diglin] (https://github.com/diglin/German_LocaleFallback/commit/38c2654cbc3e66bdd9db6035cc8d56ff991ce613)

v0.4.4

Übersetzung für "Email Support Template" ergänzt.

v0.4.5

Die Datei "var/package/Delete_EmailTemplates_en_US-1.2.0.xml" berücksichtigt zusätzlich dazugekommene englischsprachige E-Mail-Vorlagen

Italienische Lokalisierung hinzugefügt.
