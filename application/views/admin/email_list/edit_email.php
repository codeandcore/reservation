<style>
	.katex {
		font: normal 1.21em KaTeX_Main, Times New Roman, serif;
		line-height: 1.2;
		text-indent: 0;
		text-rendering: auto;
	}
	.katex * {
		-ms-high-contrast-adjust: none !important;
	}
	.katex .katex-version:after {
		content: "0.11.1";
	}
	.katex .katex-mathml {
		position: absolute;
		clip: rect(1px, 1px, 1px, 1px);
		padding: 0;
		border: 0;
		height: 1px;
		width: 1px;
		overflow: hidden;
	}
	.katex .katex-html > .newline {
		display: block;
	}
	.katex .base {
		position: relative;
		white-space: nowrap;
		width: min-content;
	}
	.katex .base,
	.katex .strut {
		display: inline-block;
	}
	.katex .textbf {
		font-weight: 700;
	}
	.katex .textit {
		font-style: italic;
	}
	.katex .textrm {
		font-family: KaTeX_Main;
	}
	.katex .textsf {
		font-family: KaTeX_SansSerif;
	}
	.katex .texttt {
		font-family: KaTeX_Typewriter;
	}
	.katex .mathdefault {
		font-family: KaTeX_Math;
		font-style: italic;
	}
	.katex .mathit {
		font-family: KaTeX_Main;
		font-style: italic;
	}
	.katex .mathrm {
		font-style: normal;
	}
	.katex .mathbf {
		font-family: KaTeX_Main;
		font-weight: 700;
	}
	.katex .boldsymbol {
		font-family: KaTeX_Math;
		font-weight: 700;
		font-style: italic;
	}
	.katex .amsrm,
	.katex .mathbb,
	.katex .textbb {
		font-family: KaTeX_AMS;
	}
	.katex .mathcal {
		font-family: KaTeX_Caligraphic;
	}
	.katex .mathfrak,
	.katex .textfrak {
		font-family: KaTeX_Fraktur;
	}
	.katex .mathtt {
		font-family: KaTeX_Typewriter;
	}
	.katex .mathscr,
	.katex .textscr {
		font-family: KaTeX_Script;
	}
	.katex .mathsf,
	.katex .textsf {
		font-family: KaTeX_SansSerif;
	}
	.katex .mathboldsf,
	.katex .textboldsf {
		font-family: KaTeX_SansSerif;
		font-weight: 700;
	}
	.katex .mathitsf,
	.katex .textitsf {
		font-family: KaTeX_SansSerif;
		font-style: italic;
	}
	.katex .mainrm {
		font-family: KaTeX_Main;
		font-style: normal;
	}
	.katex .vlist-t {
		display: inline-table;
		table-layout: fixed;
	}
	.katex .vlist-r {
		display: table-row;
	}
	.katex .vlist {
		display: table-cell;
		vertical-align: bottom;
		position: relative;
	}
	.katex .vlist > span {
		display: block;
		height: 0;
		position: relative;
	}
	.katex .vlist > span > span {
		display: inline-block;
	}
	.katex .vlist > span > .pstrut {
		overflow: hidden;
		width: 0;
	}
	.katex .vlist-t2 {
		margin-right: -2px;
	}
	.katex .vlist-s {
		display: table-cell;
		vertical-align: bottom;
		font-size: 1px;
		width: 2px;
		min-width: 2px;
	}
	.katex .msupsub {
		text-align: left;
	}
	.katex .mfrac > span > span {
		text-align: center;
	}
	.katex .mfrac .frac-line {
		display: inline-block;
		width: 100%;
		border-bottom-style: solid;
	}
	.katex .hdashline,
	.katex .hline,
	.katex .mfrac .frac-line,
	.katex .overline .overline-line,
	.katex .rule,
	.katex .underline .underline-line {
		min-height: 1px;
	}
	.katex .mspace {
		display: inline-block;
	}
	.katex .clap,
	.katex .llap,
	.katex .rlap {
		width: 0;
		position: relative;
	}
	.katex .clap > .inner,
	.katex .llap > .inner,
	.katex .rlap > .inner {
		position: absolute;
	}
	.katex .clap > .fix,
	.katex .llap > .fix,
	.katex .rlap > .fix {
		display: inline-block;
	}
	.katex .llap > .inner {
		right: 0;
	}
	.katex .clap > .inner,
	.katex .rlap > .inner {
		left: 0;
	}
	.katex .clap > .inner > span {
		margin-left: -50%;
		margin-right: 50%;
	}
	.katex .rule {
		display: inline-block;
		border: 0 solid;
		position: relative;
	}
	.katex .hline,
	.katex .overline .overline-line,
	.katex .underline .underline-line {
		display: inline-block;
		width: 100%;
		border-bottom-style: solid;
	}
	.katex .hdashline {
		display: inline-block;
		width: 100%;
		border-bottom-style: dashed;
	}
	.katex .sqrt > .root {
		margin-left: 0.27777778em;
		margin-right: -0.55555556em;
	}
	.katex .fontsize-ensurer.reset-size1.size1,
	.katex .sizing.reset-size1.size1 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size1.size2,
	.katex .sizing.reset-size1.size2 {
		font-size: 1.2em;
	}
	.katex .fontsize-ensurer.reset-size1.size3,
	.katex .sizing.reset-size1.size3 {
		font-size: 1.4em;
	}
	.katex .fontsize-ensurer.reset-size1.size4,
	.katex .sizing.reset-size1.size4 {
		font-size: 1.6em;
	}
	.katex .fontsize-ensurer.reset-size1.size5,
	.katex .sizing.reset-size1.size5 {
		font-size: 1.8em;
	}
	.katex .fontsize-ensurer.reset-size1.size6,
	.katex .sizing.reset-size1.size6 {
		font-size: 2em;
	}
	.katex .fontsize-ensurer.reset-size1.size7,
	.katex .sizing.reset-size1.size7 {
		font-size: 2.4em;
	}
	.katex .fontsize-ensurer.reset-size1.size8,
	.katex .sizing.reset-size1.size8 {
		font-size: 2.88em;
	}
	.katex .fontsize-ensurer.reset-size1.size9,
	.katex .sizing.reset-size1.size9 {
		font-size: 3.456em;
	}
	.katex .fontsize-ensurer.reset-size1.size10,
	.katex .sizing.reset-size1.size10 {
		font-size: 4.148em;
	}
	.katex .fontsize-ensurer.reset-size1.size11,
	.katex .sizing.reset-size1.size11 {
		font-size: 4.976em;
	}
	.katex .fontsize-ensurer.reset-size2.size1,
	.katex .sizing.reset-size2.size1 {
		font-size: 0.83333333em;
	}
	.katex .fontsize-ensurer.reset-size2.size2,
	.katex .sizing.reset-size2.size2 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size2.size3,
	.katex .sizing.reset-size2.size3 {
		font-size: 1.16666667em;
	}
	.katex .fontsize-ensurer.reset-size2.size4,
	.katex .sizing.reset-size2.size4 {
		font-size: 1.33333333em;
	}
	.katex .fontsize-ensurer.reset-size2.size5,
	.katex .sizing.reset-size2.size5 {
		font-size: 1.5em;
	}
	.katex .fontsize-ensurer.reset-size2.size6,
	.katex .sizing.reset-size2.size6 {
		font-size: 1.66666667em;
	}
	.katex .fontsize-ensurer.reset-size2.size7,
	.katex .sizing.reset-size2.size7 {
		font-size: 2em;
	}
	.katex .fontsize-ensurer.reset-size2.size8,
	.katex .sizing.reset-size2.size8 {
		font-size: 2.4em;
	}
	.katex .fontsize-ensurer.reset-size2.size9,
	.katex .sizing.reset-size2.size9 {
		font-size: 2.88em;
	}
	.katex .fontsize-ensurer.reset-size2.size10,
	.katex .sizing.reset-size2.size10 {
		font-size: 3.45666667em;
	}
	.katex .fontsize-ensurer.reset-size2.size11,
	.katex .sizing.reset-size2.size11 {
		font-size: 4.14666667em;
	}
	.katex .fontsize-ensurer.reset-size3.size1,
	.katex .sizing.reset-size3.size1 {
		font-size: 0.71428571em;
	}
	.katex .fontsize-ensurer.reset-size3.size2,
	.katex .sizing.reset-size3.size2 {
		font-size: 0.85714286em;
	}
	.katex .fontsize-ensurer.reset-size3.size3,
	.katex .sizing.reset-size3.size3 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size3.size4,
	.katex .sizing.reset-size3.size4 {
		font-size: 1.14285714em;
	}
	.katex .fontsize-ensurer.reset-size3.size5,
	.katex .sizing.reset-size3.size5 {
		font-size: 1.28571429em;
	}
	.katex .fontsize-ensurer.reset-size3.size6,
	.katex .sizing.reset-size3.size6 {
		font-size: 1.42857143em;
	}
	.katex .fontsize-ensurer.reset-size3.size7,
	.katex .sizing.reset-size3.size7 {
		font-size: 1.71428571em;
	}
	.katex .fontsize-ensurer.reset-size3.size8,
	.katex .sizing.reset-size3.size8 {
		font-size: 2.05714286em;
	}
	.katex .fontsize-ensurer.reset-size3.size9,
	.katex .sizing.reset-size3.size9 {
		font-size: 2.46857143em;
	}
	.katex .fontsize-ensurer.reset-size3.size10,
	.katex .sizing.reset-size3.size10 {
		font-size: 2.96285714em;
	}
	.katex .fontsize-ensurer.reset-size3.size11,
	.katex .sizing.reset-size3.size11 {
		font-size: 3.55428571em;
	}
	.katex .fontsize-ensurer.reset-size4.size1,
	.katex .sizing.reset-size4.size1 {
		font-size: 0.625em;
	}
	.katex .fontsize-ensurer.reset-size4.size2,
	.katex .sizing.reset-size4.size2 {
		font-size: 0.75em;
	}
	.katex .fontsize-ensurer.reset-size4.size3,
	.katex .sizing.reset-size4.size3 {
		font-size: 0.875em;
	}
	.katex .fontsize-ensurer.reset-size4.size4,
	.katex .sizing.reset-size4.size4 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size4.size5,
	.katex .sizing.reset-size4.size5 {
		font-size: 1.125em;
	}
	.katex .fontsize-ensurer.reset-size4.size6,
	.katex .sizing.reset-size4.size6 {
		font-size: 1.25em;
	}
	.katex .fontsize-ensurer.reset-size4.size7,
	.katex .sizing.reset-size4.size7 {
		font-size: 1.5em;
	}
	.katex .fontsize-ensurer.reset-size4.size8,
	.katex .sizing.reset-size4.size8 {
		font-size: 1.8em;
	}
	.katex .fontsize-ensurer.reset-size4.size9,
	.katex .sizing.reset-size4.size9 {
		font-size: 2.16em;
	}
	.katex .fontsize-ensurer.reset-size4.size10,
	.katex .sizing.reset-size4.size10 {
		font-size: 2.5925em;
	}
	.katex .fontsize-ensurer.reset-size4.size11,
	.katex .sizing.reset-size4.size11 {
		font-size: 3.11em;
	}
	.katex .fontsize-ensurer.reset-size5.size1,
	.katex .sizing.reset-size5.size1 {
		font-size: 0.55555556em;
	}
	.katex .fontsize-ensurer.reset-size5.size2,
	.katex .sizing.reset-size5.size2 {
		font-size: 0.66666667em;
	}
	.katex .fontsize-ensurer.reset-size5.size3,
	.katex .sizing.reset-size5.size3 {
		font-size: 0.77777778em;
	}
	.katex .fontsize-ensurer.reset-size5.size4,
	.katex .sizing.reset-size5.size4 {
		font-size: 0.88888889em;
	}
	.katex .fontsize-ensurer.reset-size5.size5,
	.katex .sizing.reset-size5.size5 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size5.size6,
	.katex .sizing.reset-size5.size6 {
		font-size: 1.11111111em;
	}
	.katex .fontsize-ensurer.reset-size5.size7,
	.katex .sizing.reset-size5.size7 {
		font-size: 1.33333333em;
	}
	.katex .fontsize-ensurer.reset-size5.size8,
	.katex .sizing.reset-size5.size8 {
		font-size: 1.6em;
	}
	.katex .fontsize-ensurer.reset-size5.size9,
	.katex .sizing.reset-size5.size9 {
		font-size: 1.92em;
	}
	.katex .fontsize-ensurer.reset-size5.size10,
	.katex .sizing.reset-size5.size10 {
		font-size: 2.30444444em;
	}
	.katex .fontsize-ensurer.reset-size5.size11,
	.katex .sizing.reset-size5.size11 {
		font-size: 2.76444444em;
	}
	.katex .fontsize-ensurer.reset-size6.size1,
	.katex .sizing.reset-size6.size1 {
		font-size: 0.5em;
	}
	.katex .fontsize-ensurer.reset-size6.size2,
	.katex .sizing.reset-size6.size2 {
		font-size: 0.6em;
	}
	.katex .fontsize-ensurer.reset-size6.size3,
	.katex .sizing.reset-size6.size3 {
		font-size: 0.7em;
	}
	.katex .fontsize-ensurer.reset-size6.size4,
	.katex .sizing.reset-size6.size4 {
		font-size: 0.8em;
	}
	.katex .fontsize-ensurer.reset-size6.size5,
	.katex .sizing.reset-size6.size5 {
		font-size: 0.9em;
	}
	.katex .fontsize-ensurer.reset-size6.size6,
	.katex .sizing.reset-size6.size6 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size6.size7,
	.katex .sizing.reset-size6.size7 {
		font-size: 1.2em;
	}
	.katex .fontsize-ensurer.reset-size6.size8,
	.katex .sizing.reset-size6.size8 {
		font-size: 1.44em;
	}
	.katex .fontsize-ensurer.reset-size6.size9,
	.katex .sizing.reset-size6.size9 {
		font-size: 1.728em;
	}
	.katex .fontsize-ensurer.reset-size6.size10,
	.katex .sizing.reset-size6.size10 {
		font-size: 2.074em;
	}
	.katex .fontsize-ensurer.reset-size6.size11,
	.katex .sizing.reset-size6.size11 {
		font-size: 2.488em;
	}
	.katex .fontsize-ensurer.reset-size7.size1,
	.katex .sizing.reset-size7.size1 {
		font-size: 0.41666667em;
	}
	.katex .fontsize-ensurer.reset-size7.size2,
	.katex .sizing.reset-size7.size2 {
		font-size: 0.5em;
	}
	.katex .fontsize-ensurer.reset-size7.size3,
	.katex .sizing.reset-size7.size3 {
		font-size: 0.58333333em;
	}
	.katex .fontsize-ensurer.reset-size7.size4,
	.katex .sizing.reset-size7.size4 {
		font-size: 0.66666667em;
	}
	.katex .fontsize-ensurer.reset-size7.size5,
	.katex .sizing.reset-size7.size5 {
		font-size: 0.75em;
	}
	.katex .fontsize-ensurer.reset-size7.size6,
	.katex .sizing.reset-size7.size6 {
		font-size: 0.83333333em;
	}
	.katex .fontsize-ensurer.reset-size7.size7,
	.katex .sizing.reset-size7.size7 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size7.size8,
	.katex .sizing.reset-size7.size8 {
		font-size: 1.2em;
	}
	.katex .fontsize-ensurer.reset-size7.size9,
	.katex .sizing.reset-size7.size9 {
		font-size: 1.44em;
	}
	.katex .fontsize-ensurer.reset-size7.size10,
	.katex .sizing.reset-size7.size10 {
		font-size: 1.72833333em;
	}
	.katex .fontsize-ensurer.reset-size7.size11,
	.katex .sizing.reset-size7.size11 {
		font-size: 2.07333333em;
	}
	.katex .fontsize-ensurer.reset-size8.size1,
	.katex .sizing.reset-size8.size1 {
		font-size: 0.34722222em;
	}
	.katex .fontsize-ensurer.reset-size8.size2,
	.katex .sizing.reset-size8.size2 {
		font-size: 0.41666667em;
	}
	.katex .fontsize-ensurer.reset-size8.size3,
	.katex .sizing.reset-size8.size3 {
		font-size: 0.48611111em;
	}
	.katex .fontsize-ensurer.reset-size8.size4,
	.katex .sizing.reset-size8.size4 {
		font-size: 0.55555556em;
	}
	.katex .fontsize-ensurer.reset-size8.size5,
	.katex .sizing.reset-size8.size5 {
		font-size: 0.625em;
	}
	.katex .fontsize-ensurer.reset-size8.size6,
	.katex .sizing.reset-size8.size6 {
		font-size: 0.69444444em;
	}
	.katex .fontsize-ensurer.reset-size8.size7,
	.katex .sizing.reset-size8.size7 {
		font-size: 0.83333333em;
	}
	.katex .fontsize-ensurer.reset-size8.size8,
	.katex .sizing.reset-size8.size8 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size8.size9,
	.katex .sizing.reset-size8.size9 {
		font-size: 1.2em;
	}
	.katex .fontsize-ensurer.reset-size8.size10,
	.katex .sizing.reset-size8.size10 {
		font-size: 1.44027778em;
	}
	.katex .fontsize-ensurer.reset-size8.size11,
	.katex .sizing.reset-size8.size11 {
		font-size: 1.72777778em;
	}
	.katex .fontsize-ensurer.reset-size9.size1,
	.katex .sizing.reset-size9.size1 {
		font-size: 0.28935185em;
	}
	.katex .fontsize-ensurer.reset-size9.size2,
	.katex .sizing.reset-size9.size2 {
		font-size: 0.34722222em;
	}
	.katex .fontsize-ensurer.reset-size9.size3,
	.katex .sizing.reset-size9.size3 {
		font-size: 0.40509259em;
	}
	.katex .fontsize-ensurer.reset-size9.size4,
	.katex .sizing.reset-size9.size4 {
		font-size: 0.46296296em;
	}
	.katex .fontsize-ensurer.reset-size9.size5,
	.katex .sizing.reset-size9.size5 {
		font-size: 0.52083333em;
	}
	.katex .fontsize-ensurer.reset-size9.size6,
	.katex .sizing.reset-size9.size6 {
		font-size: 0.5787037em;
	}
	.katex .fontsize-ensurer.reset-size9.size7,
	.katex .sizing.reset-size9.size7 {
		font-size: 0.69444444em;
	}
	.katex .fontsize-ensurer.reset-size9.size8,
	.katex .sizing.reset-size9.size8 {
		font-size: 0.83333333em;
	}
	.katex .fontsize-ensurer.reset-size9.size9,
	.katex .sizing.reset-size9.size9 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size9.size10,
	.katex .sizing.reset-size9.size10 {
		font-size: 1.20023148em;
	}
	.katex .fontsize-ensurer.reset-size9.size11,
	.katex .sizing.reset-size9.size11 {
		font-size: 1.43981481em;
	}
	.katex .fontsize-ensurer.reset-size10.size1,
	.katex .sizing.reset-size10.size1 {
		font-size: 0.24108004em;
	}
	.katex .fontsize-ensurer.reset-size10.size2,
	.katex .sizing.reset-size10.size2 {
		font-size: 0.28929605em;
	}
	.katex .fontsize-ensurer.reset-size10.size3,
	.katex .sizing.reset-size10.size3 {
		font-size: 0.33751205em;
	}
	.katex .fontsize-ensurer.reset-size10.size4,
	.katex .sizing.reset-size10.size4 {
		font-size: 0.38572806em;
	}
	.katex .fontsize-ensurer.reset-size10.size5,
	.katex .sizing.reset-size10.size5 {
		font-size: 0.43394407em;
	}
	.katex .fontsize-ensurer.reset-size10.size6,
	.katex .sizing.reset-size10.size6 {
		font-size: 0.48216008em;
	}
	.katex .fontsize-ensurer.reset-size10.size7,
	.katex .sizing.reset-size10.size7 {
		font-size: 0.57859209em;
	}
	.katex .fontsize-ensurer.reset-size10.size8,
	.katex .sizing.reset-size10.size8 {
		font-size: 0.69431051em;
	}
	.katex .fontsize-ensurer.reset-size10.size9,
	.katex .sizing.reset-size10.size9 {
		font-size: 0.83317261em;
	}
	.katex .fontsize-ensurer.reset-size10.size10,
	.katex .sizing.reset-size10.size10 {
		font-size: 1em;
	}
	.katex .fontsize-ensurer.reset-size10.size11,
	.katex .sizing.reset-size10.size11 {
		font-size: 1.19961427em;
	}
	.katex .fontsize-ensurer.reset-size11.size1,
	.katex .sizing.reset-size11.size1 {
		font-size: 0.20096463em;
	}
	.katex .fontsize-ensurer.reset-size11.size2,
	.katex .sizing.reset-size11.size2 {
		font-size: 0.24115756em;
	}
	.katex .fontsize-ensurer.reset-size11.size3,
	.katex .sizing.reset-size11.size3 {
		font-size: 0.28135048em;
	}
	.katex .fontsize-ensurer.reset-size11.size4,
	.katex .sizing.reset-size11.size4 {
		font-size: 0.32154341em;
	}
	.katex .fontsize-ensurer.reset-size11.size5,
	.katex .sizing.reset-size11.size5 {
		font-size: 0.36173633em;
	}
	.katex .fontsize-ensurer.reset-size11.size6,
	.katex .sizing.reset-size11.size6 {
		font-size: 0.40192926em;
	}
	.katex .fontsize-ensurer.reset-size11.size7,
	.katex .sizing.reset-size11.size7 {
		font-size: 0.48231511em;
	}
	.katex .fontsize-ensurer.reset-size11.size8,
	.katex .sizing.reset-size11.size8 {
		font-size: 0.57877814em;
	}
	.katex .fontsize-ensurer.reset-size11.size9,
	.katex .sizing.reset-size11.size9 {
		font-size: 0.69453376em;
	}
	.katex .fontsize-ensurer.reset-size11.size10,
	.katex .sizing.reset-size11.size10 {
		font-size: 0.83360129em;
	}
	.katex .fontsize-ensurer.reset-size11.size11,
	.katex .sizing.reset-size11.size11 {
		font-size: 1em;
	}
	.katex .delimsizing.size1 {
		font-family: KaTeX_Size1;
	}
	.katex .delimsizing.size2 {
		font-family: KaTeX_Size2;
	}
	.katex .delimsizing.size3 {
		font-family: KaTeX_Size3;
	}
	.katex .delimsizing.size4 {
		font-family: KaTeX_Size4;
	}
	.katex .delimsizing.mult .delim-size1 > span {
		font-family: KaTeX_Size1;
	}
	.katex .delimsizing.mult .delim-size4 > span {
		font-family: KaTeX_Size4;
	}
	.katex .nulldelimiter {
		display: inline-block;
		width: 0.12em;
	}
	.katex .delimcenter,
	.katex .op-symbol {
		position: relative;
	}
	.katex .op-symbol.small-op {
		font-family: KaTeX_Size1;
	}
	.katex .op-symbol.large-op {
		font-family: KaTeX_Size2;
	}
	.katex .op-limits > .vlist-t {
		text-align: center;
	}
	.katex .accent > .vlist-t {
		text-align: center;
	}
	.katex .accent .accent-body {
		position: relative;
	}
	.katex .accent .accent-body:not(.accent-full) {
		width: 0;
	}
	.katex .overlay {
		display: block;
	}
	.katex .mtable .vertical-separator {
		display: inline-block;
		min-width: 1px;
	}
	.katex .mtable .arraycolsep {
		display: inline-block;
	}
	.katex .mtable .col-align-c > .vlist-t {
		text-align: center;
	}
	.katex .mtable .col-align-l > .vlist-t {
		text-align: left;
	}
	.katex .mtable .col-align-r > .vlist-t {
		text-align: right;
	}
	.katex .svg-align {
		text-align: left;
	}
	.katex svg {
		display: block;
		position: absolute;
		width: 100%;
		height: inherit;
		fill: currentColor;
		stroke: currentColor;
		fill-rule: nonzero;
		fill-opacity: 1;
		stroke-width: 1;
		stroke-linecap: butt;
		stroke-linejoin: miter;
		stroke-miterlimit: 4;
		stroke-dasharray: none;
		stroke-dashoffset: 0;
		stroke-opacity: 1;
	}
	.katex svg path {
		stroke: none;
	}
	.katex img {
		border-style: none;
		min-width: 0;
		min-height: 0;
		max-width: none;
		max-height: none;
	}
	.katex .stretchy {
		width: 100%;
		display: block;
		position: relative;
		overflow: hidden;
	}
	.katex .stretchy:after,
	.katex .stretchy:before {
		content: "";
	}
	.katex .hide-tail {
		width: 100%;
		position: relative;
		overflow: hidden;
	}
	.katex .halfarrow-left {
		position: absolute;
		left: 0;
		width: 50.2%;
		overflow: hidden;
	}
	.katex .halfarrow-right {
		position: absolute;
		right: 0;
		width: 50.2%;
		overflow: hidden;
	}
	.katex .brace-left {
		position: absolute;
		left: 0;
		width: 25.1%;
		overflow: hidden;
	}
	.katex .brace-center {
		position: absolute;
		left: 25%;
		width: 50%;
		overflow: hidden;
	}
	.katex .brace-right {
		position: absolute;
		right: 0;
		width: 25.1%;
		overflow: hidden;
	}
	.katex .x-arrow-pad {
		padding: 0 0.5em;
	}
	.katex .mover,
	.katex .munder,
	.katex .x-arrow {
		text-align: center;
	}
	.katex .boxpad {
		padding: 0 0.3em;
	}
	.katex .fbox,
	.katex .fcolorbox {
		box-sizing: border-box;
		border: 0.04em solid;
	}
	.katex .cancel-pad {
		padding: 0 0.2em;
	}
	.katex .cancel-lap {
		margin-left: -0.2em;
		margin-right: -0.2em;
	}
	.katex .sout {
		border-bottom-style: solid;
		border-bottom-width: 0.08em;
	}
	.katex-display {
		display: block;
		margin: 1em 0;
		text-align: center;
	}
	.katex-display > .katex {
		display: block;
		text-align: center;
		white-space: nowrap;
	}
	.katex-display > .katex > .katex-html {
		display: block;
		position: relative;
	}
	.katex-display > .katex > .katex-html > .tag {
		position: absolute;
		right: 0;
	}
	.katex-display.leqno > .katex > .katex-html > .tag {
		left: 0;
		right: auto;
	}
	.katex-display.fleqn > .katex {
		text-align: left;
	}

	

	.sun-editor {width:auto; height:auto; border:1px solid #dadada; background-color:#FFF; z-index:10000;}
	.sun-editor th, .sun-editor td, .sun-editor input, .sun-editor select, .sun-editor textarea, .sun-editor button {font-size:14px; font-family:sans-serif; line-height:1.5; color:#111;}
	.sun-editor body, .sun-editor div, .sun-editor dl, .sun-editor dt, .sun-editor dd, .sun-editor ul, .sun-editor ol, .sun-editor li,
	.sun-editor h1, .sun-editor h2, .sun-editor h3, .sun-editor h4, .sun-editor h5, .sun-editor h6, .sun-editor pre, .sun-editor code, .sun-editor form, .sun-editor fieldset,
	.sun-editor legend, .sun-editor textarea, .sun-editor p, .sun-editor blockquote, .sun-editor th, .sun-editor td, .sun-editor input, .sun-editor select, .sun-editor textarea, .sun-editor button {margin:0; padding:0; border:0; color:#000 !important;}
	.sun-editor dl, .sun-editor ul, .sun-editor ol, .sun-editor menu, .sun-editor li {list-style: none !important;}
	.sun-editor hr {margin:6px 0 6px 0 !important;}
	.sun-editor textarea {resize:none !important; border:0 !important;}
	.sun-editor button {border:0 none; background-color:transparent; touch-action:manipulation; cursor:pointer;}
	.sun-editor input, .sun-editor select, .sun-editor textarea, .sun-editor button {vertical-align: middle;}
	.sun-editor button .txt {display: block; margin-top: 0px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}

	.sun-editor .btn_align .img_editor {display: inline-block; width:14px; height:13px; margin:-1px 10px 0 0; vertical-align:middle; text-indent:-9999px;}
	.sun-editor .layer_line .img_editor {display: inline-block; width:138px; height:1px; margin:-1px 10px 0 0; vertical-align:middle; text-indent:-9999px;}
	.sun-editor .screen_out {overflow:hidden; position:absolute; width:0; height:0; line-height:0; text-indent:-9999px;}

	.sun-editor .sun-editor-container {position:relative; width:100%; height:100%;}

	.sun-editor .sun-editor-id-toolbar-cover {position:absolute; display:none; font-size:36px; width:100%; height:100%; top:0; left:0; right:0; bottom:0; background-color:#fefefe; opacity:.5; filter:alpha(opacity=50); cursor:not-allowed; z-index:9;}
	.sun-editor .sun-editor-id-toolbar {overflow:visible; position:relative; height:auto; font-size:0pt; padding:3px 3px 3px 0px; background-color:#fafafa; border-bottom:1px solid #dadada; z-index:9;}

	.sun-editor .sun-editor-id-toolbar .tool_module {display:inline-block;}
	.sun-editor .sun-editor-id-toolbar .editor_tool {float: left;height: 32px;margin:5px 0 5px 5px;}
	.sun-editor .sun-editor-id-toolbar .editor_tool li {position:relative; float:left;}

	.sun-editor .sun-editor-id-toolbar .layer_editor {display: none; position:absolute; top:34px; left:1px; z-index:1; border:1px solid #bababa; border-radius:2px; background-color:#fff; -webkit-box-shadow:0 3px 9px rgba(0, 0, 0, .5); box-shadow:0 3px 9px rgba(0, 0, 0, .5); outline:0 none;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .write_place .inp_txt {float:left; width:100%; height:23px; margin-top:0; font-size:12px; text-indent:6px; border:0 none; outline:0 none;}
	.sun-editor .sun-editor-id-toolbar .layer_editor button {overflow: hidden; width:100%;}
	.sun-editor .sun-editor-id-toolbar .layer_editor button:hover, .sun-editor .editor_tool .layer_editor button:focus {background-color:#f4b124; border-color:#ffebc1; outline:0 none;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .list_family {left:0; width:156px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .list_family .default {border-bottom:1px solid #CCC;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .list_family_add {left:0; width:160px; border-top:1px solid #CCC;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .font_size_list {left:0; width:180px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .font_size_list .btn_edit {height:auto; padding:2px 10px 5px; line-height:100%;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .font_size_list .txt_size18 {padding:1px 10px 6px}
	.sun-editor .sun-editor-id-toolbar .layer_editor .font_size_list .txt_size24 {padding:3px 10px 11px; line-height:24px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .font_size_list .txt_size36 {padding:4px 10px 15px; line-height:36px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.layer_list {left:0; width:42px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.layer_line {left:0; width:158px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.write_place {overflow:hidden; float:left; position:relative; height:25px; border:1px solid #dadada;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.layer_color {left:0;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.pallet_bgcolor {width:196px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.list_bgcolor {width:180px; height:126px; padding:10px 6px 0 10px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.list_bgcolor li {float:left; position:relative; width:16px; height:16px; margin:0 4px 4px 0;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.more_palette {display:none; width:176px; margin:0 10px; padding:8px 0 6px; border-top:1px solid #f3f3f3;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.list_bgcolor button {display:block; overflow:hidden; width:16px; height:16px; border-radius:2px; vertical-align:top; text-indent:-9999px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .list_color .bg_check {display:none; position:absolute; top:1px; left:1px; width:12px; height:12px; border:1px solid #fff; border-radius:1px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.list_bgcolor .bg_btnframe {display:none; position:absolute; top:0; left:0; width:14px; height:14px; border:1px solid #000; border-radius:2px; opacity:.2; filter:alpha(opacity=20);}
	.sun-editor .sun-editor-id-toolbar .layer_editor.box_codeinp {float:left; height:28px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.more_palette .box_bgcolor {width:24px; margin-right:2px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.view_bgcolor {float:left; width:16px; height:16px; padding:3px; border:1px solid #d7d7d7;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.view_bgcolor .inner_bgcolor {width:16px; height:16px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor.inner_bgcolor {display:block; overflow:hidden; width:15px; height:15px; margin:0 auto; text-indent:-9999px;}

	.sun-editor .sun-editor-id-toolbar .layer_color {display: none;}
	.sun-editor .sun-editor-id-toolbar .layer_align {left:9px; width:98px;}

	.sun-editor .sun-editor-id-toolbar .list_editor {overflow:hidden; width:100%; padding:6px 0;}
	.sun-editor .sun-editor-id-toolbar .list_editor li:first-child {padding-top:0;}
	.sun-editor .sun-editor-id-toolbar .list_editor li {padding-top:5px; width:100%;}
	.sun-editor .sun-editor-id-toolbar .font_size_list li {padding:0px; width:100%;}

	.sun-editor .sun-editor-id-toolbar .btn_editor {overflow:hidden; float:left; width:32px; height:32px; border:1px solid #ccc; margin-left:2px; border-radius:2px; font-size:12px; line-height:27px; background-color:#FFF;}
	.sun-editor .sun-editor-id-toolbar .btn_editor.on {border-color:#f4b124; background-color:#ffebc1; -webkit-box-shadow: inset 0 3px 5px #f4b124; box-shadow: inset 0 3px 5px #f4b124;}
	.sun-editor .sun-editor-id-toolbar .btn_editor:hover, .sun-editor .sun-editor-id-toolbar .btn_editor:focus {background-color: #ffebc1; border-color: #f4b124; outline: 0 none;}

	.sun-editor .sun-editor-id-toolbar .btn_edit {width:100%; height:28px; padding:0 14px; margin-left:0; font-size:12px; line-height:22px; text-indent:0; text-decoration:none; text-align:left;}
	.sun-editor .sun-editor-id-toolbar .btn_font {width:80px; text-align:left; text-indent:10px;}
	.sun-editor .sun-editor-id-toolbar .btn_size {width:75px; text-align:left; text-indent:7px;}
	.sun-editor .sun-editor-id-toolbar .btn_line {padding:0 5px 0 5px;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .list_color .btn_color.checked_color .bg_check {display:block;}
	.sun-editor .sun-editor-id-toolbar .layer_editor .list_color .btn_color.checked_color {border:1px solid #000;}

	.sun-editor .sun-editor-id-toolbar .ico_more {position:absolute; top:14px; right:10px; width:7px; height:7px; background:url('<?php echo base_url(); ?>/uploads/assets/images/br_down_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_bold {width:16px; height:16px; margin:0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/font_bold_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_underline {width:16px; height:16px; margin:0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/font_underline_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_italic {width:16px; height:16px; margin:0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/font_italic_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_strike {width:16px; height:16px; margin:0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/font_strokethrough_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_fcolor {width:16px; height:16px; margin:0 auto; margin-bottom: 5px; background:url('<?php echo base_url(); ?>/uploads/assets/images/pencil_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .color_font {overflow: hidden; position:absolute; top:24px; left:9px; width:19px; height:3px; text-indent:-9999px;}
	.sun-editor .sun-editor-id-toolbar .ico_fcolor_w {width:16px; height:16px; margin:0 auto; margin-bottom: 5px; background:url('<?php echo base_url(); ?>/uploads/assets/images/fill_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_align_l {width:17px; height:17px; background:url('<?php echo base_url(); ?>/uploads/assets/images/align_left_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_align_r {width:17px; height:17px; background:url('<?php echo base_url(); ?>/uploads/assets/images/align_right_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_align_c {width:17px; height:17px; background:url('<?php echo base_url(); ?>/uploads/assets/images/align_center_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_align_f {width:17px; height:17px; background:url('<?php echo base_url(); ?>/uploads/assets/images/align_just_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_list {display: inline-block; width:17px; height:17px;}
	.sun-editor .sun-editor-id-toolbar .ico_list_num {display:block; margin:0 auto;background:url('<?php echo base_url(); ?>/uploads/assets/images/list_num_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_list_square {background:url('<?php echo base_url(); ?>/uploads/assets/images/list_bullets_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_indnet {width:17px; height:17px; margin: 0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/indent_increase_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_outdent {width:17px; height:17px; margin: 0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/indent_decrease_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_indent {background-position:-220px -160px;}
	.sun-editor .sun-editor-id-toolbar .ico_line {position:absolute; top:10px; left:9px; width:14px; height:13px; background-position:-190px 0;}
	.sun-editor .sun-editor-id-toolbar .ico_table {width:17px; height:17px; margin: 0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/3x3_grid_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_url {width:17px; height:17px; margin: 0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/link_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_picture {width:17px; height:17px; margin: 0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/picture_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_video {width:17px; height:17px; margin: 0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/movie_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_full_screen_e {width:17px; height:17px; margin: 0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/expand_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_full_screen_i {width:17px; height:17px; margin: 0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/import_icon&48.png') no-repeat; background-size:100%;}
	.sun-editor .sun-editor-id-toolbar .ico_html {width:17px; height:17px; margin: 0 auto; background:url('<?php echo base_url(); ?>/uploads/assets/images/brackets_icon&48.png') no-repeat; background-size:100%;}

	.sun-editor .sun-editor-id-toolbar .img_line1 {height:2px; background-position:0 -30px;}
	.sun-editor .sun-editor-id-toolbar .img_line2 {height:3px; background-position:0 -35px;}
	.sun-editor .sun-editor-id-toolbar .img_line3 {height:6px; background-position:0 -40px;}

	.sun-editor .sun-editor-id-toolbar .editor_link {padding:8px 5px 12px 15px;}
	.sun-editor .sun-editor-id-toolbar .editor_link .write_place {height:79px; border:0; overflow:hidden; float:left; position:relative;}
	.sun-editor .sun-editor-id-toolbar .editor_link .write_place .lab_url {position:absolute;top:0;left:0;width:228px;height:23px;font-size:12px;line-height:24px;color:#999; cursor:text;}
	.sun-editor .sun-editor-id-toolbar .editor_link .write_place .inp_txt {height:23px; font-size:12px; font-family:Verdana; line-height:24px; text-indent:0px; margin-top:8px; border:1px solid #CCC}
	.sun-editor .sun-editor-id-toolbar .editor_link .btn_apply_url {float:right; width:35px; height:69px;}

	.sun-editor .sun-editor-id-toolbar .layer_color .pallet_bgcolor {width:196px;}
	.sun-editor .sun-editor-id-toolbar .layer_color .list_bgcolor {width:100%; height:126px; padding:10px 6px 0 10px;}
	.sun-editor .sun-editor-id-toolbar .layer_color .list_bgcolor li {float:left; position:relative; width:16px; height:16px; margin:0 4px 4px 0;}
	.sun-editor .sun-editor-id-toolbar .layer_color .list_bgcolor button {display:block; overflow:hidden; width:16px; height:16px; border-radius:2px; vertical-align:top; text-indent:-9999px;}
	.sun-editor .sun-editor-id-toolbar .layer_color .list_bgcolor button.color_white {display:block; overflow:hidden; width:16px; height:16px; border:1px solid #d3d3d3; vertical-align:top; text-indent:-9999px;}
	.sun-editor .sun-editor-id-toolbar .layer_color .list_bgcolor .bg_btnframe {display:none; position:absolute; top:0; left:0; width:14px; height:14px; border:1px solid #000; border-radius:2px; opacity:.2; filter:alpha(opacity=20);}

	.sun-editor .sun-editor-id-toolbar .layer_color .pallet_text {width:156px;}
	.sun-editor .sun-editor-id-toolbar .layer_color .pallet_text .ex_txtbgcolor {position:relative; z-index:1; width:158px; height:25px; border-radius:2px; border-bottom:0 none; margin: -1px 0 0 -1px;}
	.sun-editor .sun-editor-id-toolbar .layer_color .pallet_text .ex_txtbgcolor .emph_txtbgcolor {display:block; width:147px; height:25px; padding-left:11px; font-size:12px; line-height:24px; color:#fff; -webkit-transition-property:background-color,color; -webkit-transition-duration:.2s; transition-property:background-color,color; transition-duration:.2s;}
	.sun-editor .sun-editor-id-toolbar .layer_color .pallet_text .ex_txtbgcolor .bg_frame {position:absolute; top:0; left:0; width:156px; height:24px; border:1px solid #000; border-bottom:0 none; opacity:.1; filter:alpha(opacity=10); -webkit-transition:opacity .2s; -webkit-transition:opacity .2s;}
	.sun-editor .sun-editor-id-toolbar .layer_color .pallet_text .list_color {width:140px; height:44px; margin:8px 6px 0 10px; padding:0; border-top:0;}

	.sun-editor  .sun-editor-id-editorArea {width:100%;}
	.sun-editor  .sun-editor-id-editorArea .input_editor {width:100%; height:100%; background-color:#FFF;}
	.sun-editor  .sun-editor-id-editorArea .input_editor.html {/*padding:8px;*/ outline-style:none;}

	.sun-editor .sun-editor-id-resizeBar {width:100%; height:10px; border-top:1px solid #dadada; background-color:#fafafa; cursor:ns-resize;}
	.sun-editor .sun-editor-id-resize-background {position:absolute; display:none; top:0; left:0; width:100%; height:100%; z-index:10000;}

	.sun-editor .sun-editor-id-dialogBox {position:absolute; display:none; top:0; left:0; width:100%; height:100%; z-index:9999;}
	.sun-editor .sun-editor-id-dialogBox label, .sun-editor .sun-editor-id-dialogBox input, .sun-editor .sun-editor-id-dialogBox button {font-size:14px; line-height:1.5; color:#111; margin:0;}
	.sun-editor .sun-editor-id-dialogBox .modal-dialog-background {position:absolute; width:100%; height:100%; top:0px; left:0px; background-color:#222; opacity:0.5; z-index:10;}

	.sun-editor .modal-dialog {position:absolute; width:100%; height:100%; top:0px; left:0px; z-index:11;}
	.sun-editor .modal-dialog .modal-content {position:relative; width:500px; margin:8px auto; background-color:#fff; -webkit-background-clip:padding-box; background-clip:padding-box; border:1px solid #999; border:1px solid rgba(0, 0, 0, .2); border-radius:6px; outline:0; -webkit-box-shadow:0 3px 9px rgba(0, 0, 0, .5); box-shadow:0 3px 9px rgba(0, 0, 0, .5); z-index:11;}
	@media screen and (max-width: 509px) {.sun-editor .modal-dialog .modal-content {width:100%;} }
	.sun-editor .modal-dialog .modal-header {padding:15px 15px 5px 15px; border-bottom:1px solid #e5e5e5;}
	.sun-editor .modal-dialog button.close {-webkit-appearance:none; padding:0; cursor:pointer; background:transparent; border:0;}
	.sun-editor .modal-dialog .close {float:right; font-size:21px; font-weight:bold; line-height:1; color:#000; text-shadow:0 1px 0 #fff; filter:alpha(opacity=100); opacity: 1;}
	.sun-editor .modal-dialog .close:hover, .sun-editor .modal-dialog .close:focus {color:#f4b124 !important;}
	.sun-editor .modal-dialog .modal-body {position:relative; padding:15px;}
	.sun-editor .modal-dialog .form-group {margin-bottom:15px;}
	.sun-editor .modal-dialog .form-size .size-text {width:100%;}
	.sun-editor .modal-dialog .form-size .size-text .size-w {width:70px; text-align:center;}
	.sun-editor .modal-dialog .form-size .size-text .size-h {width:70px; text-align:center;}
	.sun-editor .modal-dialog .form-size .size-x {margin:0 8px 0 8px;}
	.sun-editor .modal-dialog .form-size-control {display:inline-block; width:70px; height:34px; /*padding:6px 12px;*/ font-size:14px; line-height:1.42857143; color:#555; background-color:#fff; background-image:none; border:1px solid #ccc; border-radius:4px; -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075); box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075); -webkit-transition:border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s; -o-transition:border-color ease-in-out .15s, box-shadow ease-in-out .15s; transition:border-color ease-in-out .15s, box-shadow ease-in-out .15s;}
	.sun-editor .modal-dialog .modal-content label {display:inline-block; max-width:100%; margin-bottom:5px; font-weight:bold;}
	.sun-editor .modal-dialog .form-control {display:block; width:100%; height:34px; /*padding:6px 12px;*/ font-size:14px; line-height:1.42857143; color:#555; background-color:#fff; background-image:none; border:1px solid #ccc; border-radius:4px; -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075); box-shadow:inset 0 1px 1px rgba(0, 0, 0, .075); -webkit-transition:border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s; -o-transition:border-color ease-in-out .15s, box-shadow ease-in-out .15s; transition:border-color ease-in-out .15s, box-shadow ease-in-out .15s;}
	.sun-editor .modal-dialog .modal-footer {padding:10px 15px 0px 15px; text-align:right; border-top:1px solid #e5e5e5;}
	.sun-editor .modal-dialog .btn-primary {color:#fff; background-color:#f4b124; border-color:#f4b124;}
	.sun-editor .modal-dialog .modal-content .btn {display:inline-block; padding:6px 12px; margin-bottom:0; font-size:14px; font-weight:normal; line-height:1.42857143; text-align:center; white-space:nowrap; vertical-align:middle; -ms-touch-action:manipulation; touch-action:manipulation; cursor:pointer; -webkit-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none; background-image:none; border:1px solid transparent; border-radius:4px;}
	.sun-editor .modal-dialog .modal-content .btn:hover, .sun-editor .modal-dialog .modal-content .btn:focus {background-color: #f4a500;}
	.sun-editor .modal-dialog .modal-content input:focus {border-color:#f4b124; outline:0; -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(244, 177, 36, .6); box-shadow:inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(244, 177, 36, .6);}

	.sun-editor .sun-editor-id-loding {position:absolute; display:none; width:100%; height:100%; top:0px; left:0px; background-color:#191f26; background-image:url('../img/loding.jpg'); background-repeat:no-repeat; background-position:center; background-size:auto auto; opacity:.7; filter:alpha(opacity=70); z-index:9999;}
	.sun-editor .sun-editor-id-loding .ico-loding {display:none;}

	.sun-editor .table-content {position:absolute; top:34px; left:1px; z-index:11; padding:5px; float:left; padding:5px 0; margin:2px 0 0; font-size:14px; text-align:left; list-style:none; background-color:#fff; -webkit-background-clip:padding-box; background-clip:padding-box; border:1px solid #ccc; border:1px solid rgba(0, 0, 0, .15); border-radius:4px; -webkit-box-shadow:0 6px 12px rgba(0, 0, 0, .175); box-shadow:0 6px 12px rgba(0, 0, 0, .175);}
	.sun-editor .table-data-form {font-size:18px; padding:0 5px;}
	.sun-editor .table-picker {position:absolute!important; z-index:3; font-size:18px; width:10em; height:10em; cursor:pointer;}
	.sun-editor .table-highlighted {position:absolute!important; z-index:2; font-size:18px; width:1em; height:1em; background:url('../img/pixel_sun.png') repeat;}
	.sun-editor .table-unhighlighted {position:relative!important; z-index:1; font-size:18px; width:5em; height:5em; background:url('../img/pixel_white.png') repeat;}
	.sun-editor .table-display {padding-left:5px;}

	.sun-editor .modal-image-resize {position:absolute; display:none; background-color:black; opacity:0.3; z-index:8;}
	.sun-editor .modal-image-resize .image-resize-dot {position:absolute; width:7px; height:7px; border:1px solid black;}
	.sun-editor .modal-image-resize .tl {top:-5px; left:-5px; border-right:0; border-bottom:0;}
	.sun-editor .modal-image-resize .tr {top:-5px; right:-5px; border-bottom:0; border-left:none;}
	.sun-editor .modal-image-resize .bl {bottom:-5px; left:-5px; border-top:0; border-right:0;}
	.sun-editor .modal-image-resize .br-controller {right:-5px; bottom:-5px; background-color:#F00; cursor:se-resize;}
	.sun-editor .modal-image-resize .image-size-display {position:absolute;	right:0; bottom:0; padding:5px; margin:5px; font-size:12px; color:white; background-color:black; -webkit-border-radius:5px; -moz-border-radius:5px; border-radius:5px; -webkit-opacity:.7; -khtml-opacity:.7; -moz-opacity:.7; opacity:.7;}

	.sun-editor .image-resize-btn {position:absolute; display:none; top:0; left:0; margin-top:-50px !important; z-index:12; display:none; max-width:310px; padding:1px; font-family:"Helvetica Neue", Helvetica, Arial, sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:1.42857143; text-align:left; text-align:start; text-decoration:none; text-shadow:none; text-transform:none; letter-spacing:normal; word-break:normal; word-spacing:normal; word-wrap:normal; white-space:normal; background-color:#fff; -webkit-background-clip:padding-box; background-clip:padding-box; border:1px solid #ccc; border:1px solid rgba(0, 0, 0, .2); border-radius:6px; -webkit-box-shadow:0 5px 10px rgba(0, 0, 0, .2); box-shadow:0 5px 10px rgba(0, 0, 0, .2); line-break:auto;}
	.sun-editor .image-resize-btn .btn-group {position:relative; display:inline-block; vertical-align:middle; padding:5px 5px 5px 0;}
	.sun-editor .image-resize-btn .btn-group button {position:relative; float:left; border-top-right-radius:0; border-bottom-right-radius:0; margin:0 0 0 2px !important; padding:5px 10px !important; font-size:12px !important; line-height:1.5 !important; border:1px solid #222 !important; border-radius:3px !important; color:#333; background-color:#fff !important; border-color:#ccc !important; display:inline-block; font-size:14px !important; font-weight:normal; text-align:center; white-space:nowrap; vertical-align:middle; -ms-touch-action:manipulation; touch-action:manipulation; -webkit-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none;}
	.sun-editor .image-resize-btn .btn-group.remove button {width:100%; height:100%;}
	.sun-editor .image-resize-btn .btn-group.remove button .image_remove {font-weight:bold;}
	.sun-editor .image-resize-btn button:hover, .sun-editor .image-resize-btn button:focus {background-color:#ffebc1 !important; border-color:#f4b124 !important; outline:0 none !important;}
	.sun-editor {width: 100% !important;}
	.booking_list_wrapper form#update_email_template {
    	width: 100%;
	}
	.sun-editor .sun-editor-id-editorArea{height:800px !important;}

	.CodeMirror {
		font-family: monospace;
		height: 300px;
		color: #000;
		direction: ltr;
	}
	.CodeMirror-lines {
		padding: 4px 0;
	}
	.CodeMirror pre.CodeMirror-line,
	.CodeMirror pre.CodeMirror-line-like {
		padding: 0 4px;
	}
	.CodeMirror-gutter-filler,
	.CodeMirror-scrollbar-filler {
		background-color: #fff;
	}
	.CodeMirror-gutters {
		border-right: 1px solid #ddd;
		background-color: #f7f7f7;
		white-space: nowrap;
	}
	.CodeMirror-linenumber {
		padding: 0 3px 0 5px;
		min-width: 20px;
		text-align: right;
		color: #999;
		white-space: nowrap;
	}
	.CodeMirror-guttermarker {
		color: #000;
	}
	.CodeMirror-guttermarker-subtle {
		color: #999;
	}
	.CodeMirror-cursor {
		border-left: 1px solid #000;
		border-right: none;
		width: 0;
	}
	.CodeMirror div.CodeMirror-secondarycursor {
		border-left: 1px solid silver;
	}
	.cm-fat-cursor .CodeMirror-cursor {
		width: auto;
		border: 0 !important;
		background: #7e7;
	}
	.cm-fat-cursor div.CodeMirror-cursors {
		z-index: 1;
	}
	.cm-fat-cursor-mark {
		background-color: rgba(20, 255, 20, 0.5);
		-webkit-animation: blink 1.06s steps(1) infinite;
		-moz-animation: blink 1.06s steps(1) infinite;
		animation: blink 1.06s steps(1) infinite;
	}
	.cm-animate-fat-cursor {
		width: auto;
		border: 0;
		-webkit-animation: blink 1.06s steps(1) infinite;
		-moz-animation: blink 1.06s steps(1) infinite;
		animation: blink 1.06s steps(1) infinite;
		background-color: #7e7;
	}
	@-moz-keyframes blink {
		50% {
			background-color: transparent;
		}
	}
	@-webkit-keyframes blink {
		50% {
			background-color: transparent;
		}
	}
	@keyframes blink {
		50% {
			background-color: transparent;
		}
	}
	.cm-tab {
		display: inline-block;
		text-decoration: inherit;
	}
	.CodeMirror-rulers {
		position: absolute;
		left: 0;
		right: 0;
		top: -50px;
		bottom: 0;
		overflow: hidden;
	}
	.CodeMirror-ruler {
		border-left: 1px solid #ccc;
		top: 0;
		bottom: 0;
		position: absolute;
	}
	.cm-s-default .cm-header {
		color: #00f;
	}
	.cm-s-default .cm-quote {
		color: #090;
	}
	.cm-negative {
		color: #d44;
	}
	.cm-positive {
		color: #292;
	}
	.cm-header,
	.cm-strong {
		font-weight: 700;
	}
	.cm-em {
		font-style: italic;
	}
	.cm-link {
		text-decoration: underline;
	}
	.cm-strikethrough {
		text-decoration: line-through;
	}
	.cm-s-default .cm-keyword {
		color: #708;
	}
	.cm-s-default .cm-atom {
		color: #219;
	}
	.cm-s-default .cm-number {
		color: #164;
	}
	.cm-s-default .cm-def {
		color: #00f;
	}
	.cm-s-default .cm-variable-2 {
		color: #05a;
	}
	.cm-s-default .cm-type,
	.cm-s-default .cm-variable-3 {
		color: #085;
	}
	.cm-s-default .cm-comment {
		color: #a50;
	}
	.cm-s-default .cm-string {
		color: #a11;
	}
	.cm-s-default .cm-string-2 {
		color: #f50;
	}
	.cm-s-default .cm-meta {
		color: #555;
	}
	.cm-s-default .cm-qualifier {
		color: #555;
	}
	.cm-s-default .cm-builtin {
		color: #30a;
	}
	.cm-s-default .cm-bracket {
		color: #997;
	}
	.cm-s-default .cm-tag {
		color: #170;
	}
	.cm-s-default .cm-attribute {
		color: #00c;
	}
	.cm-s-default .cm-hr {
		color: #999;
	}
	.cm-s-default .cm-link {
		color: #00c;
	}
	.cm-s-default .cm-error {
		color: red;
	}
	.cm-invalidchar {
		color: red;
	}
	.CodeMirror-composing {
		border-bottom: 2px solid;
	}
	div.CodeMirror span.CodeMirror-matchingbracket {
		color: #0b0;
	}
	div.CodeMirror span.CodeMirror-nonmatchingbracket {
		color: #a22;
	}
	.CodeMirror-matchingtag {
		background: rgba(255, 150, 0, 0.3);
	}
	.CodeMirror-activeline-background {
		background: #e8f2ff;
	}
	.CodeMirror {
		position: relative;
		overflow: hidden;
		background: #fff;
	}
	.CodeMirror-scroll {
		overflow: scroll !important;
		margin-bottom: -30px;
		margin-right: -30px;
		padding-bottom: 30px;
		height: 100%;
		outline: 0;
		position: relative;
	}
	.CodeMirror-sizer {
		position: relative;
		border-right: 30px solid transparent;
	}
	.CodeMirror-gutter-filler,
	.CodeMirror-hscrollbar,
	.CodeMirror-scrollbar-filler,
	.CodeMirror-vscrollbar {
		position: absolute;
		z-index: 6;
		display: none;
	}
	.CodeMirror-vscrollbar {
		right: 0;
		top: 0;
		overflow-x: hidden;
		overflow-y: scroll;
	}
	.CodeMirror-hscrollbar {
		bottom: 0;
		left: 0;
		overflow-y: hidden;
		overflow-x: scroll;
	}
	.CodeMirror-scrollbar-filler {
		right: 0;
		bottom: 0;
	}
	.CodeMirror-gutter-filler {
		left: 0;
		bottom: 0;
	}
	.CodeMirror-gutters {
		position: absolute;
		left: 0;
		top: 0;
		min-height: 100%;
		z-index: 3;
	}
	.CodeMirror-gutter {
		white-space: normal;
		height: 100%;
		display: inline-block;
		vertical-align: top;
		margin-bottom: -30px;
	}
	.CodeMirror-gutter-wrapper {
		position: absolute;
		z-index: 4;
		background: 0 0 !important;
		border: none !important;
	}
	.CodeMirror-gutter-background {
		position: absolute;
		top: 0;
		bottom: 0;
		z-index: 4;
	}
	.CodeMirror-gutter-elt {
		position: absolute;
		cursor: default;
		z-index: 4;
	}
	.CodeMirror-gutter-wrapper ::selection {
		background-color: transparent;
	}
	.CodeMirror-gutter-wrapper ::-moz-selection {
		background-color: transparent;
	}
	.CodeMirror-lines {
		cursor: text;
		min-height: 1px;
	}
	.CodeMirror pre.CodeMirror-line,
	.CodeMirror pre.CodeMirror-line-like {
		-moz-border-radius: 0;
		-webkit-border-radius: 0;
		border-radius: 0;
		border-width: 0;
		background: 0 0;
		font-family: inherit;
		font-size: inherit;
		margin: 0;
		white-space: pre;
		word-wrap: normal;
		line-height: inherit;
		color: inherit;
		z-index: 2;
		position: relative;
		overflow: visible;
		-webkit-tap-highlight-color: transparent;
		-webkit-font-variant-ligatures: contextual;
		font-variant-ligatures: contextual;
	}
	.CodeMirror-wrap pre.CodeMirror-line,
	.CodeMirror-wrap pre.CodeMirror-line-like {
		word-wrap: break-word;
		white-space: pre-wrap;
		word-break: normal;
	}
	.CodeMirror-linebackground {
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		z-index: 0;
	}
	.CodeMirror-linewidget {
		position: relative;
		z-index: 2;
		padding: 0.1px;
	}
	.CodeMirror-rtl pre {
		direction: rtl;
	}
	.CodeMirror-code {
		outline: 0;
	}
	.CodeMirror-gutter,
	.CodeMirror-gutters,
	.CodeMirror-linenumber,
	.CodeMirror-scroll,
	.CodeMirror-sizer {
		-moz-box-sizing: content-box;
		box-sizing: content-box;
	}
	.CodeMirror-measure {
		position: absolute;
		width: 100%;
		height: 0;
		overflow: hidden;
		visibility: hidden;
	}
	.CodeMirror-cursor {
		position: absolute;
		pointer-events: none;
	}
	.CodeMirror-measure pre {
		position: static;
	}
	div.CodeMirror-cursors {
		visibility: hidden;
		position: relative;
		z-index: 3;
	}
	div.CodeMirror-dragcursors {
		visibility: visible;
	}
	.CodeMirror-focused div.CodeMirror-cursors {
		visibility: visible;
	}
	.CodeMirror-selected {
		background: #d9d9d9;
	}
	.CodeMirror-focused .CodeMirror-selected {
		background: #d7d4f0;
	}
	.CodeMirror-crosshair {
		cursor: crosshair;
	}
	.CodeMirror-line::selection,
	.CodeMirror-line > span::selection,
	.CodeMirror-line > span > span::selection {
		background: #d7d4f0;
	}
	.CodeMirror-line::-moz-selection,
	.CodeMirror-line > span::-moz-selection,
	.CodeMirror-line > span > span::-moz-selection {
		background: #d7d4f0;
	}
	.cm-searching {
		background-color: #ffa;
		background-color: rgba(255, 255, 0, 0.4);
	}
	.cm-force-border {
		padding-right: 0.1px;
	}
	@media print {
		.CodeMirror div.CodeMirror-cursors {
			visibility: hidden;
		}
	}
	.cm-tab-wrap-hack:after {
		content: "";
	}
	span.CodeMirror-selectedtext {
		background: 0 0;
	}


</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="heading_title">Edit Email</h2>
            <div class="booking_list_wrapper">
                <form action="<?php echo site_url('admin/update_email');?>" id="update_email_template" method="post">
                    <div class="form-group">
                        <label for="email_subject"> Email Subject:
                            <input type="text" name="email_subject" id="email_subject" placeholder="Enter Email Subject" value="<?php echo $data['email_subject'];?>">
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="email_subject"> Email Subject:
                            <textarea name="email_body" class="defaultEditor" id="email_body" placeholder="Enter Email Body"><?php echo $data['email_body'];?></textarea>
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary" onclick="sun_save()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
	// ClassicEditor.create(document.querySelector('.defaultEditor')).catch(error => {
	// 	console.error(error);
	// 	editor.resize('100%', '350')
	// });
	// var suneditor =  SUNEDITOR.create('email_body'); 	
	// function sun_save() {
	// 	suneditor.insertHTML(html);
    //     suneditor.save();
    // }

</script>
