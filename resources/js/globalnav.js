// マイページサブメニュー　（PCサイズのみ）
let navPos = '';
if( $( '.js-sub-nav-targt' ).length){
	navPos = $( '.js-sub-nav-targt' ).offset().top; // グローバルメニューの位置
}
const navWidth = $( '.js-sub-nav-targt' ).innerWidth();
const navHeight = $( '.js-sub-nav-targt' ).outerHeight(); // グローバルメニューの高さ
$( window ).on( 'scroll', function() {
	if ( $( this ).scrollTop() > navPos && navWidth >= 787) {
        $( '.l-main' ).css( 'padding-top', navHeight );
		$( '.js-sub-nav-targt' ).addClass( 'm_fixed' );
	} else {
		$( '.l-main' ).css( 'padding-top', 0 );
		$( '.js-sub-nav-targt' ).removeClass( 'm_fixed' );
	}
});

//ナビゲーションをクリックした際のスムーススクロール
$('.js-sub-nav-targt a').on('click',function () {
	const elmHash = $(this).attr('href'); //hrefの内容を取得
	const pos = Math.round($(elmHash).offset().top); //headerの高さを引く
	$('body,html').animate({scrollTop: pos}, 500);//取得した位置にスクロール※数値が大きいほどゆっくりスクロール
	return false;//リンクの無効化
  });