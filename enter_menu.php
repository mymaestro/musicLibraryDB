<?php
define('PAGE_TITLE', 'Enter');
define('PAGE_NAME', 'enter');
require_once("includes/header.php");
$u_admin = FALSE;
$u_librarian = FALSE;
$u_user = FALSE;
if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	$u_admin = (strpos(htmlspecialchars($_SESSION['roles']), 'administrator') !== FALSE ? TRUE : FALSE);
	$u_librarian = (strpos(htmlspecialchars($_SESSION['roles']), 'librarian') !== FALSE ? TRUE : FALSE);
	$u_user = (strpos(htmlspecialchars($_SESSION['roles']), 'user') !== FALSE ? TRUE : FALSE);
}
require_once("includes/config.php");
require_once("includes/navbar.php");
?>

<main role="main" class="container">
	<h1 class="visually-hidden">Enter library materials</h1>
	<br />

	<div class="container px-4 py-5" id="featured-3">
		<h2 class="pb-2 border-bottom">Enter music library materials</h2>
		<div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
			<div class="feature col">
				<div class="icon-square text-body-emphasis bg-body-primary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3"> <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-palette" viewBox="0 0 16 16">
						<path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m4 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M5.5 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m.5 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
						<path d="M16 8c0 3.15-1.866 2.585-3.567 2.07C11.42 9.763 10.465 9.473 10 10c-.603.683-.475 1.819-.351 2.92C9.826 14.495 9.996 16 8 16a8 8 0 1 1 8-8m-8 7c.611 0 .654-.171.655-.176.078-.146.124-.464.07-1.119-.014-.168-.037-.37-.061-.591-.052-.464-.112-1.005-.118-1.462-.01-.707.083-1.61.704-2.314.369-.417.845-.578 1.272-.618.404-.038.812.026 1.16.104.343.077.702.186 1.025.284l.028.008c.346.105.658.199.953.266.653.148.904.083.991.024C14.717 9.38 15 9.161 15 8a7 7 0 1 0-7 7" />
					</svg> </div>
				<h3 class="fs-2 text-body-emphasis">Compositions</h3>
				<p>Work with compositions in the music library. This table holds the data about the music in the library. You find here the title, composer, arranger, publish date, and so forth.</p> <a href="compositions.php" class="icon-link">
					Compositions
					<svg class="bi" aria-hidden="true">
						<use xlink:href="#chevron-right"></use>
					</svg> </a>
			</div>
			<div class="feature col">
				<div class="icon-square text-body-emphasis bg-body-primary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3"> <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-puzzle" viewBox="0 0 16 16">
						<path d="M3.112 3.645A1.5 1.5 0 0 1 4.605 2H7a.5.5 0 0 1 .5.5v.382c0 .696-.497 1.182-.872 1.469a.5.5 0 0 0-.115.118l-.012.025L6.5 4.5v.003l.003.01q.005.015.036.053a.9.9 0 0 0 .27.194C7.09 4.9 7.51 5 8 5c.492 0 .912-.1 1.19-.24a.9.9 0 0 0 .271-.194.2.2 0 0 0 .039-.063v-.009l-.012-.025a.5.5 0 0 0-.115-.118c-.375-.287-.872-.773-.872-1.469V2.5A.5.5 0 0 1 9 2h2.395a1.5 1.5 0 0 1 1.493 1.645L12.645 6.5h.237c.195 0 .42-.147.675-.48.21-.274.528-.52.943-.52.568 0 .947.447 1.154.862C15.877 6.807 16 7.387 16 8s-.123 1.193-.346 1.638c-.207.415-.586.862-1.154.862-.415 0-.733-.246-.943-.52-.255-.333-.48-.48-.675-.48h-.237l.243 2.855A1.5 1.5 0 0 1 11.395 14H9a.5.5 0 0 1-.5-.5v-.382c0-.696.497-1.182.872-1.469a.5.5 0 0 0 .115-.118l.012-.025.001-.006v-.003a.2.2 0 0 0-.039-.064.9.9 0 0 0-.27-.193C8.91 11.1 8.49 11 8 11s-.912.1-1.19.24a.9.9 0 0 0-.271.194.2.2 0 0 0-.039.063v.003l.001.006.012.025c.016.027.05.068.115.118.375.287.872.773.872 1.469v.382a.5.5 0 0 1-.5.5H4.605a1.5 1.5 0 0 1-1.493-1.645L3.356 9.5h-.238c-.195 0-.42.147-.675.48-.21.274-.528.52-.943.52-.568 0-.947-.447-1.154-.862C.123 9.193 0 8.613 0 8s.123-1.193.346-1.638C.553 5.947.932 5.5 1.5 5.5c.415 0 .733.246.943.52.255.333.48.48.675.48h.238zM4.605 3a.5.5 0 0 0-.498.55l.001.007.29 3.4A.5.5 0 0 1 3.9 7.5h-.782c-.696 0-1.182-.497-1.469-.872a.5.5 0 0 0-.118-.115l-.025-.012L1.5 6.5h-.003a.2.2 0 0 0-.064.039.9.9 0 0 0-.193.27C1.1 7.09 1 7.51 1 8s.1.912.24 1.19c.07.14.14.225.194.271a.2.2 0 0 0 .063.039H1.5l.006-.001.025-.012a.5.5 0 0 0 .118-.115c.287-.375.773-.872 1.469-.872H3.9a.5.5 0 0 1 .498.542l-.29 3.408a.5.5 0 0 0 .497.55h1.878c-.048-.166-.195-.352-.463-.557-.274-.21-.52-.528-.52-.943 0-.568.447-.947.862-1.154C6.807 10.123 7.387 10 8 10s1.193.123 1.638.346c.415.207.862.586.862 1.154 0 .415-.246.733-.52.943-.268.205-.415.39-.463.557h1.878a.5.5 0 0 0 .498-.55l-.001-.007-.29-3.4A.5.5 0 0 1 12.1 8.5h.782c.696 0 1.182.497 1.469.872.05.065.091.099.118.115l.025.012.006.001h.003a.2.2 0 0 0 .064-.039.9.9 0 0 0 .193-.27c.14-.28.24-.7.24-1.191s-.1-.912-.24-1.19a.9.9 0 0 0-.194-.271.2.2 0 0 0-.063-.039H14.5l-.006.001-.025.012a.5.5 0 0 0-.118.115c-.287.375-.773.872-1.469.872H12.1a.5.5 0 0 1-.498-.543l.29-3.407a.5.5 0 0 0-.497-.55H9.517c.048.166.195.352.463.557.274.21.52.528.52.943 0 .568-.447.947-.862 1.154C9.193 5.877 8.613 6 8 6s-1.193-.123-1.638-.346C5.947 5.447 5.5 5.068 5.5 4.5c0-.415.246-.733.52-.943.268-.205.415-.39.463-.557z" />
					</svg> </div>
				<h3 class="fs-2 text-body-emphasis">Parts</h3>
				<p>Work with instrument parts for each composition. You find which parts are in a composition, and where they are located.</p> <a href="parts.php" class="icon-link">
					Parts
					<svg class="bi" aria-hidden="true">
						<use xlink:href="#chevron-right"></use>
					</svg> </a>
			</div>
			<div class="feature col">
				<div class="icon-square text-body-emphasis bg-body-primary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3"> <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-shadows" viewBox="0 0 16 16">
						<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-8 7a.5.5 0 0 1 0-1h3.5q.048 0 .093.009A7 7 0 0 0 12.9 13H8a.5.5 0 0 1 0-1h5.745q.331-.474.581-1H8a.5.5 0 0 1 0-1h6.71a7 7 0 0 0 .22-1H8a.5.5 0 0 1 0-1h7q0-.51-.07-1H8a.5.5 0 0 1 0-1h6.71a7 7 0 0 0-.384-1H8a.5.5 0 0 1 0-1h5.745a7 7 0 0 0-.846-1H8a.5.5 0 0 1 0-1h3.608A7 7 0 1 0 8 15" />
					</svg> </div>
				<h3 class="fs-2 text-body-emphasis">Instruments</h3>
				<p>Work with instruments. You find all of the possible instruments that play your compositions, and sort them in a meaningful order.</p> <a href="#" class="icon-link">
					Instruments
					<svg class="bi" aria-hidden="true">
						<use xlink:href="#chevron-right"></use>
					</svg> </a>
			</div>
		</div>

		<div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
			<div class="feature col">
				<div class="icon-square text-body-emphasis bg-body-primary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3"> <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
						<path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
						<path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
					</svg></div>
				<h3 class="fs-2 text-body-emphasis">Playgrams</h3>
				<p>Work with "playgrams". Playgrams are program playlists, or lists of compositions to be performed, in order, at a concert.</p> <a href="playgrams.php" class="icon-link">
					Playgrams
					<svg class="bi" aria-hidden="true">
						<use xlink:href="#chevron-right"></use>
					</svg> </a>
			</div>
			<div class="feature col">
				<div class="icon-square text-body-emphasis bg-body-primary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3"> <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-music-note-list" viewBox="0 0 16 16">
						<path d="M12 13c0 1.105-1.12 2-2.5 2S7 14.105 7 13s1.12-2 2.5-2 2.5.895 2.5 2" />
						<path fill-rule="evenodd" d="M12 3v10h-1V3z" />
						<path d="M11 2.82a1 1 0 0 1 .804-.98l3-.6A1 1 0 0 1 16 2.22V4l-5 1z" />
						<path fill-rule="evenodd" d="M0 11.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5m0-4A.5.5 0 0 1 .5 7H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5m0-4A.5.5 0 0 1 .5 3H8a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5" />
					</svg></div>
				<h3 class="fs-2 text-body-emphasis">Concerts</h3>
				<p>Work with concerts. Concerts are performances of playlists at a venue on a particular date.</p> <a href="concerts.php" class="icon-link">
					Concerts
					<svg class="bi" aria-hidden="true">
						<use xlink:href="#chevron-right"></use>
					</svg> </a>
			</div>
			<div class="feature col">
				<div class="icon-square text-body-emphasis bg-body-primary d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3"> <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-cassette" viewBox="0 0 16 16">
						<path d="M4 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2m9-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0M7 6a1 1 0 0 0 0 2h2a1 1 0 1 0 0-2z" />
						<path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zM1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-.691l-1.362-2.724A.5.5 0 0 0 12 10H4a.5.5 0 0 0-.447.276L2.19 13H1.5a.5.5 0 0 1-.5-.5zM11.691 11l1 2H3.309l1-2z" />
					</svg> </div>
				<h3 class="fs-2 text-body-emphasis">Recordings</h3>
				<p>Work with recordings. Recordings are digital audio files that captured a concert performance of one composition at a concert.</p> <a href="recordings.php" class="icon-link">
					Recordings
					<svg class="bi" aria-hidden="true">
						<use xlink:href="#chevron-right"></use>
					</svg> </a>
			</div>
		</div>
	</div>

	<br />
	<div class="container px-4 py-5">
		<h2 class="pb-2 border-bottom">Supporting data</h2>
<!--		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-5"> -->
		<div class="row d-flex g-4 py-5">
			<div class="col d-flex align-items-start">
				<div>
					<h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Ensembles</h5>
						<p>Work with ensembles - bands and smaller ensembles.</p>
						<a href="ensembles.php" class="card-link">Ensembles</a>
				</div>
			</div>
			<div class="col d-flex align-items-start">
				<div>
					<h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Genres</h5>
						<p>Work types of music genre, used for classifying your music.</p>
						<a href="genres.php" class="card-link">Genres</a>
				</div>
			</div>
			<div class="col d-flex align-items-start">
				<div>
					<h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Part types</h5>
						<p>Work with types of parts, for example, Flute 1 or Tuba</p>
						<a href="parttypes.php" class="card-link">Part types</a>
				</div>
			</div>
			<div class="col d-flex align-items-start">
				<div>
					<h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Part type collections</h5>
						<p>Work with instruments that are on parts, for example, Percussion 1 or Horn 1 & 2</p>
						<a href="partcollections.php" class="card-link">Collections</a>
				</div>
			</div>
			<div class="col d-flex align-items-start">
				<div>
					<h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Paper sizes</h5>
						<p>Work with sizes of parts, for example, Folio, march or book</p>
						<a href="papersizes.php" class="card-link">Part paper sizes</a>
				</div>
			</div>
		</div>
	</div>
</main>
<?php require_once("includes/footer.php"); ?>
</body>

</html>