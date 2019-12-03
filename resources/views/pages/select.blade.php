@extends('layouts.app')
@section('content')
<div class="section">
		<div class="container" align="center">
	
						<div class="well" style="padding-top: 55px;">
								<font size="7" color="Black">Please check your status</font><br>
								<h3>あなたの性別・年代・国籍を教えてください</h3>
								<hr>
							<form method="get" action="/selection">
								{{ csrf_field() }}
									{{-- <h1>性別(Gender)</h1><br> --}}
									<font size="5" color="Black">性別(Gender)</font><br>
									<label><input type="radio" name="seibetu" value="男性(Male)" required>男性(Male)&nbsp;&nbsp;</label>
									<label><input type="radio" name="seibetu" value="女性(Female)" required>女性(Female)</label><br><br><br>
									{{-- <label><input type="button" value="チェックされている項目の値" onclick="alert($('input[name=\'seibetu\']:checked').val());"> --}}
									{{-- <br><br><br><h1>年代(Age)</h1><br> --}}
									<br><font size="5" color="Black">年代(Age)</font><br>
									<select id="nendai" name="age" required>
											<option value="" selected="selected">-Please Check-</option>
											@foreach($ages as $age)
											<option value="{{$age->age}}">{{$age->age}}</option>
											@endforeach
										</select><br><br><br>
										{{-- <input type="button" value="ボタン" onclick="getValue('nendai');"> --}}
									{{-- <br><br><br><h1>国籍(Nationality)</h1><br> --}}
									<br><font size="5" color="Black">国籍(Nationality)</font><br>
										<select id="nationality" name="nationality" required>
											<option value="" selected="selected">-Please Check-</option>
											@foreach($nationalities as $nationality)
											<option value="{{$nationality->nationality}}">{{$nationality->nationality}}</option>
											@endforeach
										</select>
										<br><br><br><br><br><br><br>
										{{-- <input type="submit" value="submit"> --}}
										<button type="submit" class="btn btn-primary pull-center" value="submit">送信(Submit)</button>

										<br><br>
							</form>
						</div>
					</div>
	</div>


    <!-- ここから追加： F5 と Ctrl+R、Command+R によるリロードを抑える -->
    <!-- Windows Safari の F5 の場合は問題の出ない再読み込みを行う -->
    <script type="text/javascript">
		var if_ctrl = 0;
		var if_r = 0;
		function is_ctrl(pressKey){
				if(pressKey==17){ //ctrl
						return 1;
				} else if (navigator.userAgent.match(/macintosh/i)){
						if (pressKey == 224 && navigator.userAgent.match(/firefox/i)){
								return 1;
						} else if (pressKey == 91 || pressKey == 93){
								return 1;
						}
				}
				return 0;
		}
		function disable_reload(e){
				if(navigator.userAgent.match(/msie/i) && window.event){
						window.event.returnValue=false;
						window.event.keyCode=0
				} else
				if (navigator.userAgent.match(/macintosh/i) || e.preventDefault){
						e.preventDefault();
						e.stopPropagation();
				}
				return false;
		}
		function catchkeydown(e){
				var pressKey;
				if (eval(e)){
						pressKey=e.keyCode;
				} else {
						pressKey=event.keyCode;
				}
				if(is_ctrl(pressKey)==1){ //ctrl
						if_ctrl=1;
						if(if_r==1){return disable_reload(e);}
				}
				if(pressKey==82){ //r
						if_r=1;
						if(if_ctrl==1){return disable_reload(e);}
				}
				if(pressKey==116){ //f5
						if (navigator.userAgent.match(/safari/i) 
								&& !navigator.userAgent.match(/chrome/i)){
								window.location="%_myname_%?n=%_n_%&i=%_i_%";
								return true;
						} else {
								return disable_reload(e);
						}
				}
		}
		function catchkeyup(e){
				var pressKey;
				if (eval(e)){
						pressKey=e.keyCode;
				} else {
						pressKey=event.keyCode;
				}
				if(is_ctrl(pressKey)==1){ //ctrl
						if_ctrl=0;
						if(if_r==1){return disable_reload(e);}
				}
				if(pressKey==82){ //r
						if_r=0;
						if(if_ctrl==1){return disable_reload(e);}
				}
				if(pressKey==116){ //f5
						if (navigator.userAgent.match(/safari/i) 
								&& !navigator.userAgent.match(/chrome/i)){
								window.location="%_myname_%?n=%_n_%&i=%_i_%";
						} else {
								return disable_reload(e);
						}
				}
		}
		document.onkeydown = catchkeydown;
		document.onkeyup = catchkeyup;

		history.pushState(null, null, null);
		$(window).on("popstate", function (event) {
			if (!event.originalEvent.state) {
				history.pushState(null, null, null);
				return;
			}
		});
    </script>
    <!-- ここまで追加： F5 と Ctrl+R、Command+R によるリロードを抑える -->

@endsection
