
<?php

include("_debut.inc.php");
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");

// CONNEXION AU SERVEUR MYSQL PUIS SÉLECTION DE LA BASE DE DONNÉES festival

$connexion=connect();
$ut8=utf8($connexion);

// MODIFIER UN ÉTABLISSEMENT 

// Déclaration du tableau des civilités
$tabCivilite=array("M.","Mme","Melle");  
$action=$_REQUEST['action'];
$id=$_REQUEST['idEtablissement'];

// Si on ne "vient" pas de ce formulaire, il faut récupérer les données à partir 
// de la base (en appelant la fonction obtenirDetailEtablissement) sinon on 
// affiche les valeurs précédemment contenues dans le formulaire
if ($action=='demanderModifEtab')
{
   $lgEtab=obtenirDetailEtablissement($connexion, $id);
  
   $nom=$lgEtab['nom'];
   $adresseRue=$lgEtab['adresseRue'];
   $codePostal=$lgEtab['codePostal'];
   $ville=$lgEtab['ville'];
   $tel=$lgEtab['tel'];
   $adresseElectronique=$lgEtab['adresseElectronique'];
   $type=$lgEtab['type'];
   $civiliteResponsable=$lgEtab['civiliteResponsable'];
   $nomResponsable=$lgEtab['nomResponsable'];
   $prenomResponsable=$lgEtab['prenomResponsable'];
   $nombreChambresOffertes=$lgEtab['nombreChambresOffertes'];
}
else
{
   $nom=$_REQUEST['nom']; 
   $adresseRue=$_REQUEST['adresseRue'];
   $codePostal=$_REQUEST['codePostal'];
   $ville=$_REQUEST['ville'];
   $tel=$_REQUEST['tel'];
   $adresseElectronique=$_REQUEST['adresseElectronique'];
   $type=$_REQUEST['type'];
   $civiliteResponsable=$_REQUEST['civiliteResponsable'];
   $nomResponsable=$_REQUEST['nomResponsable'];
   $prenomResponsable=$_REQUEST['prenomResponsable'];
   $nombreChambresOffertes=$_REQUEST['nombreChambresOffertes'];

   verifierDonneesEtabM($connexion, $id, $nom, $adresseRue, $codePostal, $ville,  
                        $tel, $nomResponsable, $nombreChambresOffertes);      
   if (nbErreurs()==0)
   {        
      modifierEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, $ville, 
                            $tel, $adresseElectronique, $type, $civiliteResponsable, 
                            $nomResponsable, $prenomResponsable, $nombreChambresOffertes);
   }
}

?>
        href="modificationEtablissement.php?action=demanderModifEtab&idEtablissement=<?php echo $id ?>">Modification
        Etablissement</a> </center> <br>
<?php echo "<form method='POST' action='modificationEtablissement.php?action=demanderModifEtab&idEtablissement=". $id ."'>"; ?>
<input type='hidden' value='validerModifEtab' name='action'>
<center>
    <h4> Modification d'un Établissement </h4>
</center>
<div class="mx-auto" style="width: 800px;">
    <table class="table table-hover">
        <tr>
            <td> id : <input type='text' class="form-control" name='id' <?php echo "value='" . $id . "'" ?> size='1'
                    maxlength='8' readonly>
                <br>
            </td>
            <td>
            <td></td>
            </td>
        </tr>
        <tr>
            <td>Nom : <input type="text" class="form-control" name="nom" <?php echo "value='" . $nom . "'" ?>
                    maxlength="45" required></td>
            <td>Adresse :<input type="text" class="form-control" name="adresseRue"
                    <?php echo "value='" . $adresseRue . "'" ?> maxlength="45" required></td>
            <td>Code Postal :<input type="number" class="form-control" name="codePostal"
                    <?php echo "value='" . $codePostal . "'" ?>
                    onKeyDown="if(this.value.length==5 && event.keyCode!=8) return false;"></td>
        </tr>
        <tr>
            <td>Ville :<input type="text" class="form-control" name="ville" <?php echo "value='" . $ville . "'" ?>
                    maxlength="35" required></td>
            <td>Téléphone :<input type="tel" class="form-control" name="tel" <?php echo "value='" . $tel . "'" ?>
                    maxlength="10" required></td>
            <td>E-mail (non obligatoire) :<input type="email" class="form-control"
                    <?php echo "value='" . $adresseElectronique . "'" ?> name="adresseElectronique" maxlength="70"></td>
        </tr>
        <tr>
            <br> <br>
            <td> <br> <strong> Type: </strong> </td>
            <?php 
            if ($type == 0) {
                ?>
            <td> <br> <input type='radio' name='type' value='1'> Etablissement Scolaire </td>
            <td> <br> <input type='radio' name='type' value='0' checked> autre </td>
            <?php
            } else {
                ?>
            <td> <br> <input type='radio' name='type' value='1' checked> Etablissement Scolaire </td>
            <td> <br> <input type='radio' name='type' value='0'> autre </td>
            <?php
            }
            ?>
        </tr>

        </td>
        </tr>
        <tr>
            <td> <br> <br> <strong>Responsable :</strong></td>
            </select>
            <td> <br> Nom : <input type="text" class="form-control" <?php echo "value='" . $nomResponsable . "'" ?>
                    name="nomResponsable" size="26" maxlength="25">
            </td>
            <td> <br> Prénom : <input type="text" class="form-control"
                    <?php echo "value='" . $prenomResponsable . "'" ?> name="prenomResponsable" size="26"
                    maxlength="25"> </td>
        </tr>
        <tr>
            <td></td>
            <td> <br> Civilité :
                <div id="civiliteResponsable">
                    <input type="text" class="form-control" name="civiliteResponsable"
                    onclick="civilite()" value="<?php echo $civiliteResponsable ?>">
                </div>
            </td>
            <td> <br> Nombre chambres offertes :<input type="number" class="form-control" name="nombreChambresOffertes"
                    <?php echo "value='" . $nombreChambresOffertes . "'" ?>
                    onKeyDown="if(this.value.length==3 && event.keyCode!=8) return false;" min="0" required></td>

        </tr>
    </table>
</div>
<div class="mx-auto" style="width: 1000px;">
    <table class="table table-borderless">
        <thead>
            <tr class='ligneTabNonQuad'>
                <td width='85%'></td>
                <td><button type="submit" value="Valider" class="btn btn-primary mb-2">Valider</button></td>
            </tr>
    </table>
</div>
<script>
function civilite() {
    let elem = document.getElementById("civiliteResponsable");
    elem.innerHTML = '<?php
    echo '<select class="form-control" name="civiliteResponsable">';
    for ($i = 0; $i < 3; $i = $i + 1) {
        if ($tabCivilite[$i] == $civiliteResponsable) {
            echo "<option>".$tabCivilite[$i]."</option>";
        } else {
            echo "<option>".$tabCivilite[$i]."</option>";
            }
        }
                    ?> ';
}
</script>
<?php

// En cas de validation du formulaire : affichage des erreurs ou du message de
// confirmation
if ($action=='validerModifEtab')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo '<meta http-equiv="refresh" content="0 ; URL=listeEtablissements.php">';
   }
}
?>