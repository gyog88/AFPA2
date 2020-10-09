<?php include 'header.php'; ?>
<!-- CORPS DE PAGE -->
<div class="row m-0 p-0 mt-0 ">
    <div class="col-12 col-sm-12 p-3 p-sm-3 mb-3 mb-sm-3 shadow">
        <section>
            <!-- on masque le titre de la page. Balise H1 aide au référencement Google-->
            <h1 class="d-none">Contact</h1>
            <article class="w-100 w-sm-100">
                <p><i>* Ces zones sont obligatoires.</i></p>

                <!--Début du Formulaire---------------------------------------->
                <form method="POST" action="#"
                    id="form_contact1" name="form_contact1" class="form-block">
                    <div class="form-group ">
                        <fieldset class="pb-4 pb-sm-4">
                            <legend class="h2">Vos coordonnées</legend>
                            <div class="form-row">
                                <div class="col">
                                    <lable for="name">Votre Nom*:</lable>
                                    <input type="text" class="form-control form-control-sm" name="name" id="name"
                                        placeholder="Votre nom" autofocus />
                                    <div id="errorName" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                            <div class="form-row">
                                <div class="col">
                                    <label for="surname">Votre Pr&eacute;nom*:</label>
                                    <input type="text" class="form-control form-control-sm" name="surname" id="surname"
                                        placeholder="Votre pr&eacute;nom" />
                                    <div id="errorSurname" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                            <div class="form-row">
                                <div class="col">

                                    Sexe*:
                                    <label class="form-check-label" for="sex">
                                        <input type="radio" class="form-control-input" name="sex" id="sexF"
                                            value="female" /> F&eacute;minin
                                    </label>
                                    <label class="form-check-label" for="sex">
                                        <input type="radio" class="form-control-input" name="sex" id="sexM"
                                            value="male" />
                                        Masculin</label>
                                    <div id="errorSex" class="text-danger"></div>

                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                            <div class="form-row">
                                <div class="col">

                                    <label for="dob">Date de naissance*:</label>
                                    <input type="date" class="form-control form-control-sm" id="dob" name="dob" />
                                    <div id="errorDob" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                            <div class="form-row">
                                <div class="col">
                                    <label for="address">Adresse:</label>
                                    <input type="text" class="form-control form-control-sm" name="address" id="address"
                                        placeholder="Votre adresse" />

                                </div>
                                <!--fin de col-->
                            </div>
                            <div class="form-row">
                                <div class="col">

                                    <label for="postcode">Code Postal*:</label>
                                    <input type="text" class="form-control form-control-sm" name="postcode"
                                        id="postcode" maxlength="5" placeholder="Votre code postal" />
                                    <div id="errorPostcode" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                            <!--fin de form-row-->
                            <div class="form-row">
                                <div class="col">

                                    <label for="city">Ville:</label>
                                    <input type="text" class="form-control form-control-sm" id="city" name="city"
                                        placeholder="Votre ville" />


                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                            <div class="form-row">
                                <div class="col">


                                    <label for="email">Email*:</label>
                                    <input type="email" class="form-control form-control-sm
                                                name=" mail" id="mail" placeholder="john.smith@afpa.fr" />
                                    <div id="errorEmail" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->

                        </fieldset>
                        <fieldset class="pb-4 pb-sm-4">
                            <legend class="h2">Votre demande</legend>
                            <div class="form-row py-1 py-sm-1">
                                <div class="col">
                                    <lable for="subject">Sujet*:</lable>


                                    <select class="form-control form-control-sm" id="subject" name="subject">
                                        <option value="0" selected disabled>Veuillez sélectionner une demande
                                        </option>
                                        <option value="1">Mes commandes</option>
                                        <option value="2">Question sur un produit</option>
                                        <option value="3">Réclamation</option>
                                        <option value="4">Autres</option>
                                    </select>
                                    <div id="errorSubject" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                            <div class="form-row py-1 py-sm-1">
                                <div class="col">
                                    <lable for="question">Votre question*:</lable>

                                    <textarea name="question" id="question" class="form-control form-control-sm"
                                        placeholder="Tapez ici votre question" form="formulaire_contact1"
                                        rows="5"></textarea>
                                    <div id="errorQuestion" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                        </fieldset>
                        <fieldset>
                            <div class="form-row ml-3 ml-sm-3">
                                <div class="col">
                                    <input type="checkbox" class="form-check-input" name="traitement" id="traitement" />
                                    <label class="form-check-label" for="traitement">* J'accepte le traitement
                                        informatique de ce
                                        formulaire.</label>
                                    <div id="errorTraitement" class="text-danger"></div>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                            <div class="form-row">
                                <div class="col">
                                    <input type="submit" class="btn btn-dark btn-lg btn-sm" id="Envoyer_form_contact"
                                        name="Envoyer_form_contact" value='Envoyer' />
                                    <button type="reset" class="btn btn-dark btn-lg btn-sm" id="annuler"
                                        name="annuler">Annuler</button>
                                </div>
                                <!--fin de col-->
                            </div>
                            <!--fin de form-row-->
                        </fieldset>
                    </div>
                    <!--fin de div .form-group-->
                </form>
                <!--fin de form -->
            </article>
        </section>
    </div> <!-- fin de col-->
</div> <!-- fin de row-->

<?php include 'footer.php'; ?>