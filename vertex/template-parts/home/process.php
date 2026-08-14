<?php
/**
 * Home process section.
 *
 * @package Vertex
 */

$steps = array(
	array( 'num' => '01', 'title' => __( 'Discover', 'vertex' ), 'text' => __( 'We dig into your goals, users, and market to build a rock-solid strategy and roadmap.', 'vertex' ) ),
	array( 'num' => '02', 'title' => __( 'Design', 'vertex' ), 'text' => __( 'We craft wireframes, prototypes, and polished interfaces validated with real feedback.', 'vertex' ) ),
	array( 'num' => '03', 'title' => __( 'Develop', 'vertex' ), 'text' => __( 'We engineer fast, secure, and scalable code with rigorous testing at every step.', 'vertex' ) ),
	array( 'num' => '04', 'title' => __( 'Deploy & Grow', 'vertex' ), 'text' => __( 'We launch, measure, and iterate — turning data into continuous, compounding growth.', 'vertex' ) ),
);
?>
<section class="vx-section" id="process">
	<div class="vx-container">
		<div class="vx-section-head vx-section-head--center">
			<span class="vx-eyebrow"><?php esc_html_e( 'How We Work', 'vertex' ); ?></span>
			<h2><?php esc_html_e( 'A proven process, start to finish', 'vertex' ); ?></h2>
			<p class="vx-lead"><?php esc_html_e( 'A transparent, collaborative workflow that keeps you in the loop and delivers on time.', 'vertex' ); ?></p>
		</div>
		<div class="vx-grid vx-grid--4 vx-process">
			<?php foreach ( $steps as $step ) : ?>
				<div class="vx-step vx-reveal">
					<span class="vx-step__num"><?php echo esc_html( $step['num'] ); ?></span>
					<h3><?php echo esc_html( $step['title'] ); ?></h3>
					<p><?php echo esc_html( $step['text'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
