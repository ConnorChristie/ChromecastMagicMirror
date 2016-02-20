<div class="top left">
    <div class="date small dimmed"></div>
    <div class="time"></div>
    <div class="calendar xxsmall"></div>
</div>

<div class="top right">
    <div class="windsun small dimmed"></div>
    <div class="temp"></div>
    <div class="forecast small dimmed"></div>
    <div class="location small dimmed"></div>
</div>

<!-- 		<div class="top-ver center-hor"> -->
<!-- 			<div class="tasks light"> -->
<!-- 				<ul> -->
<!-- 					<li>Study Math</li> -->
<!-- 					<li>Study Math</li> -->
<!-- 					<li>Study Math</li> -->
<!-- 				</ul> -->
<!-- 			</div> -->
<!-- 		</div> -->

<div class="lower-third center-hor">
    <div class="compliment light"></div>
</div>

<div class="bottom center-hor">
    <div class="news medium"></div>
</div>

<div class="bottom-right">
    <div class="debug xxsmall light"></div>
</div>

<?= $this->Html->script('receiver/time/time', ['block' => 'script-after']) ?>
<?= $this->Html->script('receiver/weather/weather', ['block' => 'script-after']) ?>
<?= $this->Html->script('receiver/calendar/calendar', ['block' => 'script-after']) ?>
