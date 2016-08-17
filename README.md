# DZip-Srv
DZip-Srv offre une interface simple et épuré pour décompresser vos fichiers sur un serveur distant. Dans les cas où vous n'avez pas de serveur dédié et donc pas d'accès au protocole SSH il vous faut transvaser l'ensemble de vos fichiers avec le protocole FTP(~en règle générale).
Dans les cas où vous avez de nombreux fichiers (comme l'installation d'un CMS, entre 2000 et 6000 fichiers) ou que vous avez un faible débit internet, l'opération peut être très longue. Si votre hébergeur n'offre pas la possibilité de décompresser les fichiers au moment du transfert. Et si les autres scripts sont trop complexes à utiliser, alors DZip-Srv répond à votre besoin.
## Prés-requis
Avoir un serveur web (la base), avoir un client FTP (pour notre exemple nous utiliserons FileZilla) et avoir téléchargé Dzip-Srv.

## Utilisation
1. Installer FileZilla et installez-le,
2. Ouvrez FileZilla et connectez-vous à votre serveur,
3. Compressez vos fichiers (format zip, tar ou tar.gz conseillé),
4. Transférez votre archive sur votre serveur,
5. Transférez les scripts de Dzip-Srv sur votre serveur,
6. Via le formulaire de Dzip-Srv remplissez les champs :
    * L’emplacement de votre archive par rapport au script de décompression,
    * Le nom de votre archive (sans l’extension),
    * Choisissez dans la liste d’option l’extension de votre archive (extension rar affiché et fonctionnelle si la librairie est activé sur le serveur distant),
    * Puis indiquez le répertoire ou l’archive sera décompressé par rapport au script de décompression.
7. Supprimez DZip-Srv de votre serveur.

## Erreurs courantes
Les erreurs les plus courantes sont :
le nom de l’archive, le chemin de l’archive et le chemin de décompression sont mal renseignés, l’extension de l’archive figure dans le champ du nom de l’archive.

## Erreur exceptionnelle
Les librairies de décompressions ne sont pas actives sur votre serveur.
