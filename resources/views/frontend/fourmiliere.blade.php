@if(auth()->check() && !auth()->user()->verified)
    <div class="warning__container">
        <p>Votre compte est actuellement en attente d'approbation.</p>
        <p>Dès que votre compte sera approuvé, un courriel vous sera envoyé et vous aurez ainsi accès aux différentes informations présentes sur le site.</p>
        <p>Merci de votre patience.</p>
    </div>
@endif
<div class="fourm__container">
    <div class="fourm__content">
        <div class="h1__container">
            <a href="/" class="arrow">&#8592;</a>
            <h1>LA FOURMILIÈRE<span>LA FOURMILIÈRE</span></h1>
        </div>
        <div class="first__content">
            <div class="text__content">
                <h2>Raison d'être</h2>
                <div class="text">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A, praesentium rerum minima molestiae deleniti, beatae debitis at eveniet, iusto recusandae cumque adipisci quasi illo. Repellat sequi ea sunt possimus ducimus?</p>
                </div>
            </div>
            <div class="text__content">
                <p class="subtitle">La plateforme met à votre disposition: </p>
                <div class="list__container">
                    <li>Un forum pour échanger sur les meilleures pratiques, obtenir du soutien, bonifier vos réflexions, partager vos bons coups et relever vos défis et créer des contacts avec d’autres intervenant·es et bénévoles à travers la province;</li>
                    <li>Une banque d’outils évolutive alimentée par les membres de la communauté;</li>
                    <li>Un soutien par clavardage offert par des intervenant·es de L’Anonyme;</li>
                </div>
            </div>
        </div>
        <div class="text__img__container">
            <div class="img__container">
                <img src="https://placehold.co/645x430" alt="">
            </div>
            <div class="text__content">
                <h2>Netiquette</h2>
                <div class="text">
                    <p>Cet espace vise l’échange de pratiques en lien avec l’intimidation. Il se veut un lieu de discussion où vous pourrez chercher du soutien auprès d’intervenant·es, professionnel·les et bénévoles de divers régions et milieux.
                        <br><br>
                        Les règles du forum visent d’assurer un climat de respect où tou·tes se sentent en sécurité et de permettre des échanges efficaces. Rappelez-vous qu’il s’agit d’un lieu d’échanges sur l’intimidation, il serait dommage d’y retrouver des propos violents et intimidants.
                        <br><br>
                        Les propos inappropriés ou violents seront retirés dans les plus brefs délais et leur auteur·rice recevra un avis. La personne qui publie à nouveau des propos qui ne respectent pas la netiquette se verra exclue de la communauté de pratiques.
                    </p>
                </div>
            </div>
        </div>
        <div class="dropdown__container">
            <div class="dropdown__content">
                <h2>Climat du forum</h2>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Indulgence</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Les utilisateur·ices de la plateforme proviennent de différents milieux et cumulent une expertise diversifiée quant à l’intimidation. Bien qu’il s’agisse d’une grande richesse, il se peut que les points de vue et les connaissances sur un sujet spécifique divergent entre les individu·es. Il importe de cultiver une ouverture d’esprit et une curiosité envers les propos partagés sur la plateforme, comme tou·te individu·e détient le droit de s’exprimer selon ses connaissances et d’être respecté·e. Les désaccords amènent à se questionner et à améliorer les pratiques.
                            <br><br>
                            Si des propos semblent enfreindre le code de vie de La Fourmilière, merci d’en faire part à l’équipe de gestion de la plateforme pour qu’une modération soit effectuée.
                        </p>
                    </div>
                </div>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Courtoisie</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Il est demandé à tou·tes utilisateur·ices d’user de civisme, de politesse, de bienveillance et de bon goût dans leur utilisation de la plateforme et dans leurs échanges. Il est strictement interdit d’adopter intentionnellement tout comportement ou attitude ayant pour but de se moquer, de rabaisser ou de ridiculiser une personne contributrice ou ses propos. De tels propos feront l’objet d’une prise d’action par l’équipe de gestion de la plateforme allant jusqu’à l’expulsion définitive de La Fourmilière.</p>
                    </div>
                </div>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Convivialité</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Une attention particulière est à porter au langage utilisé et au ton des messages. Afin d’éviter tout malentendu et pour que les échanges demeurent agréables et conviviaux, il est recommandé d’utiliser un ton neutre (faire attention au sarcasme) et d’écrire dans un vocabulaire clair et précis en évitant les doubles-sens et l’utilisation d’expressions ou d’acronymes sans explication.</p>
                    </div>
                </div>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Signalement</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Si des propos semblent enfreindre le code de vie de La Fourmilière, créent un inconfort, un malaise ou provoquent de vives réactions émotionnelles chez les utilisateur·ices, merci de signaler les messages ou la discussion à l’équipe de gestion de la plateforme pour qu’une modération soit effectuée. L’équipe de La Fourmilière s’engage à faire une veille régulière de la plateforme pour assurer la convivialité de cette dernière et prendre action dans les plus brefs délais, au besoin.</p>
                    </div>
                </div>

                <div class="dropdown drop__trigger__parent">
                    <h3 class="drop__trigger">Contenu des publications</h3>
                    <i class="fa fa-angle-down drop__trigger"></i>
                </div>
                <div class="drop__content">
                    <div class="text">
                        <p>Les interventions sur un même sujet gagnent à être regroupées. Avant de créer une nouvelle publication, il est encouragé de faire une recherche sur la plateforme afin de vérifier si le sujet d'intérêt a déjà été abordé et si des réponses pourraient répondre aux questionnements actuels. Il est également encouragé de commenter les échanges déjà publiés afin que ces derniers deviennent la ressource du sujet dont il est question. De ce fait, il est recommandé de donner un titre clair et précis aux nouvelles publications afin de faciliter les recherches ultérieures sur le thème spécifique. Bien que l’intimidation soit un sujet vaste qui puisse toucher plusieurs enjeux connexes (affirmation de soi, résolution de conflits, violence, etc.), il importe que les publications, les échanges et les questions soient directement liées au thème général de l’intimidation pour éviter toute confusion ou superflu dans les informations mises en lumière.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    .dropdown {
        background-image: url('{{asset("storage/medias/banner-1200x400v2.jpg")}}');
    }
</style>
<script>
    window.addEventListener("click", e => {
        if (e.target.classList.contains("drop__trigger")) {
            console.log(e.target.parentElement.childNodes)
            let dropContent = e.target.parentElement.nextElementSibling
            let heightEl = getComputedStyle(dropContent.childNodes[1]).getPropertyValue('height')
            dropContent.classList.toggle('open')
            if (dropContent.classList.contains('open')) {
                dropContent.style.height = parseInt(heightEl) + "px"
                dropContent.style.transition = "height 0.2s linear"
            } else {
                dropContent.style.height = "0px"
                dropContent.style.transition = "height 0.2s linear"
            }
            e.target.parentElement.childNodes[3].classList.toggle('rotate')
        }
        if (e.target.classList.contains("drop__trigger__parent")) {
            let dropContent = e.target.nextElementSibling
            dropContent.classList.toggle('open')
            let heightEl = getComputedStyle(dropContent.childNodes[1]).getPropertyValue('height')
            if (dropContent.classList.contains('open')) {
                dropContent.style.height = parseInt(heightEl) + "px"
                dropContent.style.transition = "height 0.2s linear"
            } else {
                dropContent.style.height = "0px"
                dropContent.style.transition = "height 0.2s linear"
            }
            e.target.childNodes[3].classList.toggle('rotate')
        }

    })
</script>