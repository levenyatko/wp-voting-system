/**
 * Plugin voting block script.
 *
 * @package WP_Voting_System
 */

const buttons = Object.values( document.getElementsByClassName( 'wpvs__voting-btn' ) )
const xhr     = new XMLHttpRequest()

if ( 0 < buttons.length ) {
	buttons.forEach(
		button => {
			button.addEventListener(
				'click',
				function () {
					if (1 === Number( button.dataset.clicked ) ) {
						return;
					}

					button.setAttribute( 'data-clicked', 1 )

					xhr.open( 'POST', wpvsVars.ajaxUrl, true );
					xhr.responseType = 'json';

					xhr.onreadystatechange = () => {

						if ( xhr.readyState === XMLHttpRequest.DONE && 200 === xhr.status ) {

							if (xhr.response.success) {
								const wrapper     = this.closest( '.wpvs-voting-block' );
								wrapper.innerHTML = xhr.response.html;
							}

							setTimeout(
								function () {
									button.setAttribute( 'data-clicked', 0 );
								},
								1500
							);
						}
					}

					let data = new FormData();
					data.append( 'action', 'wpvs-vote' );
					data.append( 'nonce', wpvsVars.nonce );
					data.append( 'id', this.closest( '.wpvs-voting-block' ).dataset.post );

					if ( this.classList.contains( 'wpvs__voting-btn--negative' ) ) {
						data.append( 'is_positive', 0 );
					} else {
						data.append( 'is_positive', 1 );
					}

					xhr.send( data );
				}
			);
		}
	);
}
