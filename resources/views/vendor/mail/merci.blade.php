<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<style>
		/* Base */

		body, body *:not(html):not(style):not(br):not(tr):not(code) {
			font-family: Avenir, Helvetica, sans-serif;
			box-sizing: border-box;
		}

		body {
			background-color: #f5f8fa;
			color: #74787E;
			height: 100%;
			hyphens: auto;
			line-height: 1.4;
			margin: 0;
			-moz-hyphens: auto;
			-ms-word-break: break-all;
			width: 100% !important;
			-webkit-hyphens: auto;
			-webkit-text-size-adjust: none;
			word-break: break-all;
			word-break: break-word;
		}

		p,
		ul,
		ol,
		blockquote {
			line-height: 1.4;
			text-align: left;
		}

		.greetings {
			font-weight: 600;
		}

		a {
			color: #3869D4;
		}

		a img {
			border: none;
		}

		/* Typography */

		h1 {
			color: #2F3133;
			font-size: 19px;
			font-weight: bold;
			margin-top: 0;
			text-align: left;
		}

		h2 {
			color: #2F3133;
			font-size: 16px;
			font-weight: bold;
			margin-top: 0;
			text-align: left;
		}

		h3 {
			color: #2F3133;
			font-size: 14px;
			font-weight: bold;
			margin-top: 0;
			text-align: left;
		}

		p {
			color: #74787E;
			font-size: 16px;
			line-height: 1.5em;
			margin-top: 0;
			text-align: left;
		}

		p.sub {
			font-size: 12px;
		}

		img {
			max-width: 100%;
			width: 100%;
			max-width: 500px;
		}

		/* Layout */

		.wrapper {
			background-color: #f5f8fa;
			margin: 0;
			padding: 0;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.content {
			margin: 0;
			padding: 0;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		/* Header */

		.header {
			padding: 25px 0;
			text-align: center;
		}

		.header a {
			color: #bbbfc3;
			font-size: 19px;
			font-weight: bold;
			text-decoration: none;
			text-shadow: 0 1px 0 white;
		}

		/* Body */

		.body {
			background-color: #FFFFFF;
			border-bottom: 1px solid #EDEFF2;
			border-top: 1px solid #EDEFF2;
			margin: 0;
			padding: 0;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.inner-body {
			background-color: #FFFFFF;
			margin: 0 auto;
			padding: 0;
			width: 570px;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 570px;
		}

		/* Subcopy */

		.subcopy {
			border-top: 1px solid #EDEFF2;
			margin-top: 25px;
			padding-top: 25px;
		}

		.subcopy p {
			font-size: 12px;
		}

		/* Footer */

		.footer {
			margin: 0 auto;
			padding: 0;
			text-align: center;
			width: 570px;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 570px;
		}

		.footer p {
			color: #AEAEAE;
			font-size: 12px;
			text-align: center;
		}

		/* Tables */

		.table table {
			margin: 30px auto;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.table th {
			border-bottom: 1px solid #EDEFF2;
			padding-bottom: 8px;
		}

		.table td {
			color: #74787E;
			font-size: 15px;
			line-height: 18px;
			padding: 10px 0;
		}

		.content-cell {
			padding: 35px;
		}

		/* Buttons */

		.action {
			margin: 30px auto;
			padding: 0;
			text-align: center;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.button {
			border-radius: 3px;
			box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
			color: #FFF;
			display: inline-block;
			text-decoration: none;
			-webkit-text-size-adjust: none;
		}

		.button-blue {
			background-color: #3097D1;
			border-top: 10px solid #3097D1;
			border-right: 18px solid #3097D1;
			border-bottom: 10px solid #3097D1;
			border-left: 18px solid #3097D1;
		}

		.button-green {
			background-color: #2ab27b;
			border-top: 10px solid #2ab27b;
			border-right: 18px solid #2ab27b;
			border-bottom: 10px solid #2ab27b;
			border-left: 18px solid #2ab27b;
		}

		.button-red {
			background-color: #bf5329;
			border-top: 10px solid #bf5329;
			border-right: 18px solid #bf5329;
			border-bottom: 10px solid #bf5329;
			border-left: 18px solid #bf5329;
		}

		/* Panels */

		.panel {
			margin: 0 0 21px;
		}

		.panel-content {
			background-color: #EDEFF2;
			padding: 16px;
		}

		.panel-item {
			padding: 0;
		}

		.panel-item p:last-of-type {
			margin-bottom: 0;
			padding-bottom: 0;
		}

		/* Promotions */

		.promotion {
			background-color: #FFFFFF;
			border: 2px dashed #9BA2AB;
			margin: 0;
			margin-bottom: 25px;
			margin-top: 25px;
			padding: 24px;
			width: 100%;
			-premailer-cellpadding: 0;
			-premailer-cellspacing: 0;
			-premailer-width: 100%;
		}

		.promotion h1 {
			text-align: center;
		}

		.promotion p {
			font-size: 15px;
			text-align: center;
		}


		@media only screen and (max-width: 600px) {
			.inner-body {
				width: 100% !important;
			}

			.footer {
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 500px) {
			.button {
				width: 100% !important;
			}
		}
	</style>

	<table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				<table class="content" width="100%" cellpadding="0" cellspacing="0">

<tr>
    <td class="header">
        <a href="https://assos.utc.fr/comedmus/2017/">
			La Comédie Musicale de l'UTC
        </a>
    </td>
</tr>
					<tr>
						<td class="body" width="100%" cellpadding="0" cellspacing="0">
							<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
								<tr>
									<td class="content-cell">

{{-- Start Body --}}
	<p class="greetings">Madame, Monsieur,</p>
	<p>Il y a maintenant 2 mois, vous étiez 1800 à venir au Théâtre Impérial de Compiègne assister à Marée Haute, Messes Basses, et c'est pour nous la plus belle des récompenses.</p>
	<p>Nous espérons que vous aurez pris autant de plaisir à voir ce spectacle que nous en avons pris à le préparer et à le jouer.<p>
	</p>Pour notre équipe, le moment est venu de passer le flambeau, mais l'association et son aventure, elles, continuent. La prochaine Comédie Musicale a lieu en Décembre 2019, et nous espérons avoir le plaisir de vous compter parmi ses futurs spectateurs!</p>
	<br><br>
	@if($etu)
		<p>Si vous êtes intéressé pour rejoindre l'association, <a href="https://assos.utc.fr/comedmus/2017/contact/">envoyez un message ici</a> !</p>
		<br>
	@endif
	<p>	Un immense merci, de la part de toute l'équipe de Marée Haute, Messes Basses.</p>

	{{-- <img src="data:image/png;base64,{{base64_encode(file_get_contents(asset('img/merci.jpg')))}}" alt="Merci!"> --}}
    <img src="{{ $message->embed(asset('img/merci.jpg')) }}">
	
	<br><br><br><br>

	<p>Pour ne plus recevoir les informations liées à la Comédie Musicale de l'UTC, <a href="{{ route('unsubscribe') }}" title="Se désinscrire">cliquez ici.</a></p>


{{-- End Body --}}
									</td>
								</tr>
							</table>
						</td>
					</tr>

<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
            <tr>
                <td class="content-cell" align="center">
                	&copy; 2018 La Comédie Musicale de l'UTC
                </td>
            </tr>
        </table>
    </td>
</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
