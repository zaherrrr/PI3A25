$(document).ready(function () {
    $('#utildash_Enregistrer').click(function () {

        function validateEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }




        var nom =$('#utildash_nom').val();

        var prenom =$('#utildash_prenom').val();

        var img =$('#utildash_imageFile').val();

        var mail =$('#utildash_email').val();



        var password =$('#utildash_password').val();

        var roles =$('#utildash_Roles').val();




        if (nom.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ nom',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;

        }
        else if ((nom.length>15 )|| (!/^[a-zA-Z]+$/.test(nom)) )
        {
            swal({
                title: 'Error!',
                text: 'champ nom > 15 ou contient des nombres',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;

        }

        else if (prenom.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ prenom',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;

        }
        else if ((prenom.length>15 )|| (!/^[a-zA-Z]+$/.test(prenom)) )
        {
            swal({
                title: 'Error!',
                text: 'champ prenom > 15 ou contient des nombres',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;

        }
        else if (img.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ image',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;

        }
        else if (mail.length==0)
        {
            swal({
                title: 'Error!',
                text: 'remplir champ email',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;

        }
        else if (!validateEmail(mail))
        {
            swal({
                title: 'Error!',
                text: 'email non valide',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;

        }
        else if ((password.length <5)||(password.length > 10))
        {
            swal({
                title: 'Error!',
                text: 'password :il faut au moin 5 caractere et max 10',
                icon: 'error',
                button: {
                    text: "Continue",
                    value: true,
                    visible: true,
                    className: "btn btn-primary"
                }
            });
            return false;


        }


    });


});