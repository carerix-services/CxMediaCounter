CxClickCounter
================
Technical Design
<a href="#" name="e72d5356702668e596b3c2a0b740cccf55fb0ea3"></a>
<a href="#" name="0"></a>
<table cellpadding="0" cellspacing="0" class="c33">
	<tbody>
		<tr class="c16">
			<td class="c19"><p class="c3 c6 c12">
					<span class="c8"></span>
				</p></td>
			<td class="c28"><p class="c3 c12">
					<span class="c8">Author</span>
				</p></td>
			<td class="c11"><p class="c3 c12">
					<span class="c8">Jasper Stafleu</span>
				</p></td>
		</tr>
		<tr class="c16">
			<td class="c19"><p class="c3 c6 c12">
					<span class="c8"></span>
				</p></td>
			<td class="c28"><p class="c3 c12">
					<span class="c8">Email</span>
				</p></td>
			<td class="c11"><p class="c3 c12">
					<span class="c8">j.stafleu@jcgroep.nl</span>
				</p></td>
		</tr>
	</tbody>
</table>
<p class="c3 c6">
	<span class="c8"></span>
</p>
<a href="#" name="9d4de394343ef3d01d55588e6b334ea5dc1e9998"></a>
<a href="#" name="1"></a>
<table cellpadding="0" cellspacing="0" class="c33">
	<tbody>
		<tr>
			<td class="c19"><p class="c3 c12">
					<span class="c8 c21">Changelog</span>
				</p></td>
			<td class="c31"><p class="c3 c12">
					<span class="c8 c21">By</span>
				</p></td>
			<td class="c5"><p class="c3 c12">
					<span class="c8 c21">Version</span>
				</p></td>
			<td class="c2"><p class="c3 c12">
					<span class="c8 c21">Date</span>
				</p></td>
		</tr>
		<tr>
			<td class="c19"><p class="c3 c12">
					<span class="c8">First version</span>
				</p></td>
			<td class="c31"><p class="c3 c12">
					<span class="c8">Jasper Stafleu</span>
				</p></td>
			<td class="c5"><p class="c3 c12">
					<span class="c8">1.0</span>
				</p></td>
			<td class="c2"><p class="c3 c12">
					<span class="c8">2012-10-05</span>
				</p></td>
		</tr>
		<tr>
			<td class="c19"><p class="c3 c12">
					<span class="c8">Documentation for the checksum, jobs =&gt;
						vacancies, speed improvements, refactoring for visits (pixels),
						added mailopened pixel</span>
				</p></td>
			<td class="c31"><p class="c3 c12">
					<span class="c8">Jasper Stafleu</span>
				</p></td>
			<td class="c5"><p class="c3 c12">
					<span class="c8">1.0.1</span>
				</p></td>
			<td class="c2"><p class="c3 c12">
					<span class="c8">2012-10-05</span>
				</p></td>
		</tr>
		<tr>
			<td class="c19"><p class="c3 c12">
					<span class="c8">Added URL overview to &ldquo;How it
						works&rdquo;</span>
				</p></td>
			<td class="c31"><p class="c3 c12">
					<span class="c8">Henk van Tijen</span>
				</p></td>
			<td class="c5"><p class="c3 c12">
					<span class="c8">1.0.2</span>
				</p></td>
			<td class="c2"><p class="c3 c12">
					<span class="c8">2012-10-05</span>
				</p></td>
		</tr>
		<tr>
			<td class="c19"><p class="c3 c12">
					<span class="c8">Added pagevisit and visit verb, and
						&nbsp;deprecated those verbs that do the same, but with less
						options, as visit.</span>
				</p></td>
			<td class="c31"><p class="c3 c12">
					<span class="c8">Jasper Stafleu</span>
				</p></td>
			<td class="c5"><p class="c3 c12">
					<span class="c8">1.1</span>
				</p></td>
			<td class="c2"><p class="c3 c12">
					<span class="c8">2012-10-12</span>
				</p></td>
		</tr>
	</tbody>
</table>
<hr style="page-break-before: always; display: none;">
<p class="c3 c6">
	<span></span>
</p>
<h1 class="c3">
	<a name="h.gk0s9l3m1po7"></a><span>Contents</span>
</h1>
<p class="c3 c23">
	<span class="c9"><a class="c13" href="#h.gk0s9l3m1po7">Contents</a></span>
</p>
<p class="c3 c23">
	<span class="c9"><a class="c13" href="#h.ob9zlzdmc4w8">Introduction</a></span>
</p>
<p class="c3 c23">
	<span class="c9"><a class="c13" href="#h.51289mtf8hui">Design
			goals and their implications</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.hhcnngoydk48">Low
			footprint</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.91cit7botbhv">Fast
			User interaction</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.hn0pcui9kunx">Comprehensive
			information about the interaction</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.nfiu2ipm41wl">User
			interaction</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.a6ljiqhlhtss">URL
			overview</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.lh4c0jgxfc99">Queue
			handling</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.y70hw3dqd143">Carerix</a></span>
</p>
<p class="c3 c23">
	<span class="c9"><a class="c13" href="#h.7p9amrds7lyf">Available
			types</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.xerq5w60ggsc">visit</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.vmxtzmc3m5q">Default
			fields</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.k7waxb5vnghq">Links
			made</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.yffxp7lte3g">Additional
			information</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.bwgv1ij27z3s">URI
			scheme</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.wnw6tqrbece">Example</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.xg2rnuvsxcqm">mailopened</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.b6sn8hc2snb7">Default
			fields</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.ret08fy5oqna">Links
			made</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.3fu5tou3uhe6">Additional
			information</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.bp2yy2vzbw1g">URI
			scheme</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.vdr2ceirn17b">Example</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.85mi6i66j4kf">pagevisit</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.e8l41rrnwor7">Default
			fields</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.whzsk01xrafk">Links
			made</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.sfng4c3fej3e">Additional
			information</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.af7sc82h68pp">URI
			scheme</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.3ojinuayo4th">Example</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.p5qj6p33lxqw">vacancies2candidates
			(deprecated)</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.yknybnhyd0ba">Default
			fields</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.dnhih0un4u9b">Links
			made</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.pq0spak25via">Additional
			information</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.qxnubphzau5">URI
			scheme</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.s666arppczdj">Example</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.j6tljghmh55a">vacancies2contacts
			(deprecated)</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.yikvy7k6ogf3">Default
			fields</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.oqhacmt50ajp">Links
			made</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.quygddu29i8b">Additional
			information</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.fr7xdz1p2je5">URI
			scheme</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.2zzro1akma5i">Example</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.8ukma2vxad1o">candidates2contacts
			(deprecated)</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.11m2ece3vi9d">Default
			fields</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.b4nqr9spkta9">Links
			made</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.1tjvl658inkj">Additional
			information</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.p8yfahb44ndh">URI
			scheme</a></span>
</p>
<p class="c3 c14">
	<span class="c9"><a class="c13" href="#h.1py72lgoxcej">Example</a></span>
</p>
<p class="c3 c23">
	<span class="c9"><a class="c13" href="#h.g4k6oz1ofabq">Notes
			linked overview</a></span>
</p>
<p class="c3 c23">
	<span class="c9"><a class="c13" href="#h.hkluvl8mtbyd">Installation</a></span>
</p>
<p class="c3 c22">
	<span class="c9"><a class="c13" href="#h.j5a7snmrzgzn">Requirements</a></span>
</p>
<p class="c3 c23">
	<span class="c9"><a class="c13" href="#h.pat4q9rlqyu2">TODO</a></span>
</p>
<h1 class="c3">
	<a name="h.ob9zlzdmc4w8"></a><span>Introduction</span>
</h1>
<p class="c3">
	<span>CXCounter is a stand-alone application that can be used
		to log &ldquo;clicks&rdquo;. In this context, a click is a visit to
		an URI, which usually occurs due to clicking a link, but can also
		happen when an image is shown.</span>
</p>
<p class="c3">
	<span>The eventual goal of a click is to redirect the user to
		an URI, while reporting the redirection to the client through his
		Carerix App. Therefore, the user should not notice significant delay
		in opening the URI, while the client can still report about the
		effectiveness of its links.</span>
</p>
<p class="c3">
	<span>Each click is logged as an activity of type Node in the
		Carerix application, linked to the relevant records (Candidate,
		Vacancy).</span>
</p>
<p class="c3">
	<span>A typical use case for this application would be a
		recruiter (client) sending an automated list of vacancies to multiple
		candidates (users), who click on the vacancies of interest, allowing
		the recruiter to immediately see who was interested in which vacancy.</span>
</p>
<h1 class="c3 c4">
	<a name="h.vbrxx4ejitgn"></a>
</h1>
<hr style="page-break-before: always; display: none;">
<h1 class="c3 c4">
	<a name="h.1wpdhjodvk23"></a>
</h1>
<h1 class="c3">
	<a name="h.51289mtf8hui"></a><span>Design goals and their
		implications</span>
</h1>
<h2 class="c3">
	<a name="h.hhcnngoydk48"></a><span>Low footprint</span>
</h2>
<p class="c3">
	<span>Preferably, the code is virtually stand alone, the only
		configuration required would be to set up the clients XML password.
		To allow for this, the URI&rsquo;s have been set up to always contain
		the app name of the client, such that the redirecting host is
		interdependent among clients. Also, the code is to be setup to allow
		for simple drag-and-drop into another environment; the use of sqlite
		means the hosts DB scheme is unaffected, and all code can be run from
		any location in the host&rsquo;s public html folder.</span>
</p>
<h2 class="c3">
	<a name="h.91cit7botbhv"></a><span>Fast User interaction</span>
</h2>
<p class="c3">
	<span>Ideally, the user doesn&rsquo;t even notice the
		redirection, so we want the redirection itself to be done as soon as
		possible. Therefore, the click is stored in the DB as quickly as
		possible, a asynchronous call will made to a queue handling
		mechanism, a header is set for redirection and finally the script is
		exited. This means the heavy lifting of the application (sending all
		relevant information to the Carerix App) is done asynchronously, and
		does not slow down the user experience.</span>
</p>
<h2 class="c3">
	<a name="h.hn0pcui9kunx"></a><span>Comprehensive information
		about the interaction</span>
</h2>
<p class="c3">
	<span>When a note is inserted into the Carerix App, as much
		relevant details about the click should be made available, eg: if the
		link is situated within an email to a candidate, showing him a list
		of selected vacancies, the candidate, vacancy, company and its
		contact should be visible in the Carerix Note that this click
		created. The original mail that was sent should also be available for
		backreference. This all means that the URI&rsquo;s should contain all
		relevant information, but this can be different for each type of
		click; if the link is to be put on the clients website, the candidate
		information would not be available. All in all, the click system
		should be flexible enough to allow for many different types of click,
		but should also be strict enough to prevent malicious use. To reach
		this goal, each type of click will be it&rsquo;s own verb, detailing
		exactly what the rest of the URI should look like. The underlying
		code should be extensible enough to easily create new verbs.</span>
</p>
<h1 class="c3 c4">
	<a name="h.5h9nhp8sen8"></a>
</h1>
<hr style="page-break-before: always; display: none;">
<h1 class="c3 c4">
	<a name="h.p2uen7xo13u6"></a>
</h1>
<p class="c3 c6">
	<span></span>
</p>
<h2 class="c3">
	<a name="h.nfiu2ipm41wl"></a><span>User interaction</span>
</h2>
<p class="c3">
	<span>When the user visits an URI, Limonade redirection will
		take care of applying the correct class. This class implements a
		method &ldquo;redirect&rdquo;, which stores all relevant information
		about the click, triggers the queuehandler asynchronously and uses a
		302 header redirect to the URI passed in </span><span class="c1">$_REQUEST[&lsquo;url&rsquo;]</span><span>.
		The HTTP code 302 was used, because modern browsers will register
		each click, instead of redirecting once and remembering it did so.
		Therefore, 302 gives more information.</span>
</p>
<h2 class="c3">
	<a name="h.a6ljiqhlhtss"></a><span>URL overview</span>
</h2>
<p class="c3">
	<span>The URL&rsquo;s used in the emails have the following
		format:</span>
</p>
<p class="c3">
	<span class="c1">http://{host}/{directory}/{verb}/{param1}/{...}/{paramN}/?url=target_url</span>
</p>
<ol class="c29" start="1">
	<li class="c7 c3"><span>The </span><span class="c1">host</span><span>&nbsp;is
			assumed the webhost available for each Cx application:
			appname.carerix.com. [CxClickCounter could be made to work located
			in 1 central place, handling all cx customers instead of just one
			each]</span></li>
	<li class="c7 c3"><span>The </span><span class="c1">directory</span><span>&nbsp;containing
			the application is now named </span><span class="c1">cxcntr</span><span>,
			but this can be changed to any other name, because the script is
			independent of location</span></li>
	<li class="c7 c3"><span>The </span><span class="c1">verb</span><span>&nbsp;specifies
			what needs to be counted. Eg: vacancies2candidates indicate that
			vacancy&rsquo;s url&rsquo;s will be clicked by candidates.</span></li>
	<li class="c7 c3"><span>The various </span><span class="c1">param1...paramN</span><span>&nbsp;(URI
			parts / slugs) are described in the sections below, they indicate
			the </span><span class="c1">Vacancy</span><span>, </span><span class="c1">Candidate</span><span>&nbsp;and/or
	</span><span class="c1">Contact </span></li>
	<li class="c7 c3"><span>the query parameter </span><span
		class="c1">?url=target_url</span><span>&nbsp;contains the URL
			where the user will be redirected to. This is typically a
			publication of an online vacancy.</span></li>
</ol>
<h2 class="c3">
	<a name="h.lh4c0jgxfc99"></a><span>Queue handling</span>
</h2>
<p class="c3">
	<span>The queue is handled by a separate script, and has the
		following script flow</span>
</p>
<ol class="c34" start="1">
	<li class="c7 c3"><span>Retrieve an unhandled click from
			DB. Unhandled is currently defined as having a </span><span class="c1">NULL
	</span><span>value of its </span><span class="c1">synchronise_started
	</span><span>attribute. This could later be changed to allow for
			retrying failed clicks after a certain period of time.</span></li>
	<li class="c7 c3"><span>Set the clicks&rsquo;s </span><span
		class="c1">synchronise_started</span><span>&nbsp;attribute to
			prevent double submitting. Do this as quickly as possible to reduce
			the number of race conditions with other calls of the script. Later
			on, more attention could be given to table locking and preventing
			race conditions altogether. For the current scope however, this was
			decided to be too unlikely to allocate time to.</span></li>
	<li class="c7 c3"><span>Sends the click as per it&rsquo;s
			types model. This creates a note in Carerix (see below).</span></li>
	<li class="c7 c3"><span>Set the clicks finished or error
			fields.</span></li>
	<li class="c7 c3"><span>Continue on from step 1 until no
			more unhandled clicks are found</span></li>
</ol>
<h2 class="c3">
	<a name="h.y70hw3dqd143"></a><span>Carerix</span>
</h2>
<p class="c3">
	<span>In Carerix, a note (</span><span class="c1">CRToDo</span><span>&nbsp;with
	</span><span class="c1">todoTypeKey = 4</span><span>) is created by
		the queue handler through the XML api. This note MUST have </span>
</p>
<ol class="c29" start="1">
	<li class="c7 c3"><span class="c1">ActivityTypeNode</span><span>&nbsp;</span><span>with
	</span><span class="c1">exportcode=COUNTCLICK</span></li>
	<li class="c7 c3"><span>T</span><span>he email that was
			sent (if any) as its </span><span class="c1">PreviousToDo </span></li>
	<li class="c7 c3"><span>V</span><span>alid </span><span
		class="c1">owner</span><span>, </span><span class="c1">notes</span><span>&nbsp;and
	</span><span class="c1">subject</span><span>&nbsp;fields. </span></li>
</ol>
<p class="c3">
	<span>The values of the last three, as well as any other
		entities the note should be linked to, are dependent on the type of
		the click, and will be explained in the next chapter.</span>
</p>
<hr style="page-break-before: always; display: none;">
<h1 class="c3 c4">
	<a name="h.cendw7v12lc7"></a>
</h1>
<h1 class="c3">
	<a name="h.7p9amrds7lyf"></a><span>Available types</span>
</h1>
<p class="c3">
	<span>For all types (think of them as &lsquo;types of
		actions&rsquo;), the scheme MUST contain the </span><span class="c1">ClickType
	</span><span>as the first URI part and the </span><span class="c1">AppName
	</span><span>as second. It SHOULD contain a </span><span class="c1">CampaignName</span><span>,
		which is basically a string the client can choose, which will be
		shown as part of the created note&rsquo;s subject. </span>
</p>
<p class="c3">
	<span>The subject will be set to the </span><span class="c1">$_REQUEST[&lsquo;subject&rsquo;]</span><span>&nbsp;(with
		html_entities called upon it) if not empty, or will be generated as
		per the schemes below otherwise.</span>
</p>
<p class="c3">
	<span>Usually the value of </span><span class="c1">notes</span><span>&nbsp;will
		be set to </span><span class="c1">print_r($_SERVER)</span><span>, to
		allow for debugging if required.</span>
</p>
<h2 class="c3">
	<a name="h.xerq5w60ggsc"></a><span>visit</span>
</h2>
<p class="c3">
	<span>This is a generic type for creating a CRToDo and linking
		it to any of the following:</span>
</p>
<ol class="c34" start="1">
	<li class="c7 c3"><span>email</span></li>
	<li class="c7 c3"><span>vacancy</span></li>
	<li class="c7 c3"><span>employee</span></li>
	<li class="c7 c3"><span>contact</span></li>
</ol>
<p class="c3">
	<span>This verb is the new generic version, and the other verbs
		with the same goal have therefore been deprecated.</span>
</p>
<h3 class="c3">
	<a name="h.vmxtzmc3m5q"></a><span>Default fields</span>
</h3>
<ol class="c29" start="1">
	<li class="c7 c3"><span class="c1">owner</span><span>&nbsp;is
			set to the owner of the supplied employee, contact, vacancy or
			email, in that order, whichever is supplied first.</span></li>
	<li class="c7 c3"><span class="c1">notes</span><span>&nbsp;is
			set to </span><span class="c1">print_r($_SERVER).PHP_EOL.PHP_EOL.print_r($click)</span></li>
	<li class="c7 c3"><span class="c1">subject</span><span>&nbsp;is
			set to &ldquo;{</span><span class="c1">Campaign}, Employee:
			{EmployeeID}, Contact: {ContactID}, Vacancy: {VacancyID}, Email:
			{EmailID}</span><span>&ldquo;, filtering out the ones not supplied.</span></li>
	<li class="c7 c3"><span class="c1">checksum</span><span>&nbsp;is
			set to the concat of the </span><span class="c1">stableHash.hexadecimalDescription</span><span>&nbsp;of
			the available fields.</span></li>
</ol>
<h3 class="c3">
	<a name="h.k7waxb5vnghq"></a><span>Links made</span>
</h3>
<p class="c3">
	<span>Any of the supplied fields will be linked.</span>
</p>
<h3 class="c3">
	<a name="h.yffxp7lte3g"></a><span>Additional information</span>
</h3>
<p class="c3">
	<span>None.</span>
</p>
<h3 class="c3">
	<a name="h.bwgv1ij27z3s"></a><span>URI scheme</span>
</h3>
<p class="c3">
	<span class="c1">/visit/{AppName}/{Campaign}/{ExportCode}/{EmailID}/{VacancyID?}/{EmployeeID?}/{ContactID?}/{checksum}?url={RedirectURL}</span>
</p>
<p class="c3 c6">
	<span></span>
</p>
<p class="c3">
	<span>Any field that is &ldquo;empty&rdquo; (see php&rsquo;s </span><span
		class="c1">empty</span><span>&nbsp;language construct) will be
		considered to not have been supplied. Since apache webserver
		&nbsp;will change // to / in the path, this means only fields that
		have the value 0 will be used. If a certain object can&rsquo;t be
		found, it will also be considered not-supplied. If no fields have
		been supplied at all, this click will be considered as non-existent.</span>
</p>
<p class="c3">
	<span>An additional field in this type is the </span><span class="c1">ExportCode</span><span>.
		This is the required exportcode of the typeID for the CRToDo. If that
		type does not exist, the note will not be created. If exportcode is </span><span
		class="c1">empty</span><span>, </span><span class="c1">COUNTCLICK</span><span>&nbsp;will
		be used.</span>
</p>
<h3 class="c3">
	<a name="h.wnw6tqrbece"></a><span>Example</span>
</h3>
<ol class="c29" start="1">
	<li class="c7 c3"><span>Only link an email, but give it
			the status with the default exportcode<br>
	</span><span class="c9"><a class="c13"
			href="http://www.recruitersalesevent.nl/cxcntr/visit/services/TEST/0/9324/3171121711/?url=http://google.nl">http://www.recruitersalesevent.nl/cxcntr/visit/services/TEST/0/9324/3171121711/?url=http://google.nl</a></span></li>
	<li class="c7 c3"><span>Link to everything, with the
			status JOBS2CANDS, and a generated subject<br>
	</span><span class="c9"><a class="c13"
			href="http://www.recruitersalesevent.nl/cxcntr/visit/services/TEST/JOBS2CANDS/9324/442/5508/5864/%20608625648.452543454.3171121711.167069773/?url=http://google.nl&amp;subject=My%20test%20subject%3C">http://www.recruitersalesevent.nl/cxcntr/visit/services/TEST/JOBS2CANDS/9324/442/5508/5864/
				608625648.452543454.3171121711.167069773/?url=</a></span><span class="c9"><a
			class="c13" href="">http://google.nl&amp;subject=My%20test%20subject%3C</a></span></li>
</ol>
<h3 class="c3">
	<a name="h.fizbbfk7bjyo"></a><span>CxScript</span>
</h3>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;url&rdquo;
		value=&rdquo;</span><span class="c0 c9"><a class="c13"
		href="http://www.carerix.net">http://www.carerix.net</a></span><span
		class="c0">/UNIQUE_JOB_URL</span><span class="c0">&rdquo;
		keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;base&rdquo;
		value=&rdquo;http://${utilities.userDefaults.Customer}&rdquo;
		expand=&rdquo;&rdquo; keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;base&rdquo;
		value=&rdquo;${base}.carerix.net/cxcntr/visit/&rdquo;
		expand=&rdquo;&rdquo; keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;base&rdquo;
		value=&rdquo;${base}/${utilities.userDefaults.Customer}&rdquo;
		expand=&rdquo;&rdquo; keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;base&rdquo;
		value=&rdquo;${base}/jobmailing&rdquo; expand=&rdquo;&rdquo;
		keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;base&rdquo;
		value=&rdquo;${base}/JOBS2CANDS&rdquo; expand=&rdquo;&rdquo;
		keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;base&rdquo;
		value=&rdquo;${base}/${activity.id}&rdquo; expand=&rdquo;&rdquo;
		keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3 c6">
	<span class="c0"></span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:foreach item=&quot;vac&quot;
		list=&quot;$selectedItems.@sortAscending.jobTitle&quot;
		index=&quot;i&quot;&gt;</span>
</p>
<p class="c3 c6">
	<span class="c0"></span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;href&rdquo;
		value=&rdquo;${base}/${vac.vacancyID}&rdquo; expand=&rdquo;&rdquo;
		keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;href&rdquo;
		value=&rdquo;${href}/${activity.toEmployee.employeeID}&rdquo;
		expand=&rdquo;&rdquo; keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;href&rdquo;
		value=&rdquo;${href}/${activity.toContact.contactID}&rdquo;
		expand=&rdquo;&rdquo; keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;href&rdquo;
		value=&rdquo;${href}/${activity.stableHash.hexadecimaldescription}&rdquo;
		expand=&rdquo;&rdquo; keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;href&rdquo;
		value=&rdquo;${href}.${vac.stableHash.hexadecimaldescription}&rdquo;
		expand=&rdquo;&rdquo; keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;href&rdquo;
		value=&rdquo;${href}.${activity.toEmployee.stableHash.hexadecimaldescription}&rdquo;
		expand=&rdquo;&rdquo; keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;href&rdquo;
		value=&rdquo;${href}.${activity.toContact.stableHash.hexadecimaldescription}&rdquo;
		expand=&rdquo;&rdquo; keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3 c6">
	<span class="c27"></span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;href&rdquo;
		value=&rdquo;${href}?url=${url}&rdquo; expand=&rdquo;&rdquo;
		keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:let name=&rdquo;href&rdquo;
		value=&rdquo;${href}&amp;subject=To
		${activity.toEmployee.informalName}&rdquo; expand=&rdquo;&rdquo;
		keep=&rdquo;&rdquo;/&gt;</span>
</p>
<p class="c3 c6">
	<span class="c27"></span>
</p>
<p class="c3">
	<span class="c0">&lt;cx:element tag=&rdquo;a&rdquo;&gt;</span>
</p>
<p class="c3 c24">
	<span class="c0">&lt;cx:parameter name=&rdquo;href&rdquo;
		value=&rdquo;$href&rdquo;/&gt;</span>
</p>
<p class="c3 c24">
	<span class="c0">Click here (&lt;cx:write
		value=&rdquo;$href&rdquo;/&gt;) to see &lt;cx:write
		value=&rdquo;$activity.toVacancy.jobTitle&rdquo;/&gt;</span>
</p>
<p class="c3">
	<span class="c0">&lt;/cx:element&gt;</span>
</p>
<p class="c3 c6">
	<span class="c1"></span>
</p>
<p class="c3">
	<span class="c0">&lt;/cx:foreach&gt;</span>
</p>
<p class="c3 c6">
	<span></span>
</p>
<p class="c3">
	<span class="c35">?subject...</span><span>&nbsp;is optional,
		see above.</span>
</p>
<h2 class="c3">
	<a name="h.xg2rnuvsxcqm"></a><span>mailopened</span>
</h2>
<p class="c3">
	<span>This type is used to create a image end URI which allows
		the client to determine whether a mail recipients has opened its
		mail. </span><span class="c35">This is not reliable though!</span><span>&nbsp;It
		is merely an indication: most modern email clients prevent automatic
		downloading of external images, which results in the possibility
		(indeed: the likelihood) that the recipient might have read the
		email, but without loading the image, and therefore without it
		registering in your Carerix App.</span>
</p>
<h3 class="c3">
	<a name="h.b6sn8hc2snb7"></a><span>Default fields</span>
</h3>
<ol class="c29" start="5">
	<li class="c7 c3"><span class="c1">owner</span><span>&nbsp;is
			set to the owner of the visitor</span></li>
	<li class="c7 c3"><span class="c1">notes</span><span>&nbsp;is
			set to </span><span class="c1">print_r($_SERVER)</span></li>
	<li class="c7 c3"><span class="c1">subject</span><span>&nbsp;is
			set to &ldquo;</span><span class="c1">MAILOPENED {visitorType}
			{CampaigName} visitor={VisitorName}</span><span>&ldquo;</span></li>
	<li class="c7 c3"><span class="c1">checksum</span><span>&nbsp;is
			set to the visitor&rsquo;s </span><span class="c1">toUser.stableHash.hexadecimalDescription</span></li>
</ol>
<h3 class="c3">
	<a name="h.ret08fy5oqna"></a><span>Links made</span>
</h3>
<p class="c3">
	<span>Aside from the default links, the note is linked to the
		visitor, which can be a candidate or a contactperson.</span>
</p>
<h3 class="c3">
	<a name="h.3fu5tou3uhe6"></a><span>Additional information</span>
</h3>
<p class="c3">
	<span>The </span><span class="c1">CustomerName </span><span>does
		nothing at the moment.</span>
</p>
<h3 class="c3">
	<a name="h.bp2yy2vzbw1g"></a><span>URI scheme</span>
</h3>
<p class="c3">
	<span class="c1">/mailopened/{AppName}/{CustomerName}/{CampaignName}/{VisitorType}/{VisitorID}/{EmailID}/{Checksum}/{slug}?url={RedirectURL}</span>
</p>
<p class="c3 c6">
	<span></span>
</p>
<p class="c3">
	<span>Where </span><span class="c1">VisitorType</span><span>&nbsp;is
		either </span><span class="c1">employee</span><span>&nbsp;or </span><span
		class="c1">contact</span><span>. Supplying the url query is
		optional; if not supplied, a transparent image of 1x1 px will be
		returned. The slug is used to allow you to name the image of the
		resulting pixel anyway you like, as long as it has the extension </span><span
		class="c1">.gif</span><span>. This requirement is set to allow
		older browsers to show the image even if they don&rsquo;t recognize
		the mimetype.</span>
</p>
<h3 class="c3">
	<a name="h.vdr2ceirn17b"></a><span>Example</span>
</h3>
<p class="c3">
	<span class="c9"><a class="c13"
		href="http://www.recruitersalesevent.nl/pagevisit/services/166/??/px.gif">http://www.recruitersalesevent.nl/pagevisit/services/166/??/px.gif</a></span>
</p>
<ol class="c29" start="1">
	<li class="c7 c3"><span>To a contact, shows up as an
			external image: </span><span class="c9"><a class="c13"
			href="http://www.recruitersalesevent.nl/cxcntr/mailopened/services/ABBC-Holding/Test%20Campagne/employee/5514/9324/167149111/px.gif?url=https://www.google.nl/logos/2012/Teachers_Day_Alt-2012-hp.jpg">http://www.recruitersalesevent.nl/cxcntr/mailopened/services/ABBC-Holding/Test%20Campagne/employee/5514/9324/167149111/px.gif?url=https://www.google.nl/logos/2012/Teachers_Day_Alt-2012-hp.jpg</a></span></li>
</ol>
<h2 class="c3">
	<a name="h.85mi6i66j4kf"></a><span>pagevisit</span>
</h2>
<p class="c3">
	<span>This type is used to create a image end URI which allows
		the client to determine whether a webpage has been viewed.</span>
</p>
<h3 class="c3">
	<a name="h.e8l41rrnwor7"></a><span>Default fields</span>
</h3>
<ol class="c29" start="9">
	<li class="c7 c3"><span class="c1">owner</span><span>&nbsp;is
			set to the owner of the publication</span></li>
	<li class="c7 c3"><span class="c1">notes</span><span>&nbsp;is
			set to </span><span class="c1">print_r($_SERVER)</span></li>
	<li class="c7 c3"><span class="c1">subject</span><span>&nbsp;is
			set to &ldquo;</span><span class="c1">{PublicationID}-{PublicationMedium}:
			{Publication.toVacancy.jobTitle.firstChars(20)}
			[{Publication.toVacancy.vacancyID}]</span><span>&ldquo;</span></li>
	<li class="c7 c3"><span class="c1">checksum</span><span>&nbsp;is
			set to the publications </span><span class="c1">stableHash.hexadecimalDescription</span></li>
</ol>
<h3 class="c3">
	<a name="h.whzsk01xrafk"></a><span>Links made</span>
</h3>
<p class="c3">
	<span>Since the publication can not be linked to a CRToDo, the
		vacancy is linked instead. The publications medium can be determined
		from the subject.</span>
</p>
<h3 class="c3">
	<a name="h.sfng4c3fej3e"></a><span>Additional information</span>
</h3>
<p class="c3">
	<span>No additional notes.</span>
</p>
<h3 class="c3">
	<a name="h.af7sc82h68pp"></a><span>URI scheme</span>
</h3>
<p class="c3">
	<span class="c1">/pagevisit/{AppName}/{Publication}/{slug}?url={RedirectURL}</span>
</p>
<p class="c3 c6">
	<span></span>
</p>
<p class="c3">
	<span>Supplying the url query is optional; if not supplied, a
		transparent image of 1x1 px will be returned. The slug is used to
		allow you to name the image of the resulting pixel anyway you like,
		as long as it has the extension </span><span class="c1">.gif</span><span>.
		This requirement is set to allow older browsers to show the image
		even if they don&rsquo;t recognize the mimetype.</span>
</p>
<h3 class="c3">
	<a name="h.3ojinuayo4th"></a><span>Example</span>
</h3>
<p class="c3">
	<span class="c9"><a class="c13"
		href="http://www.recruitersalesevent.nl/cxcntr/pagevisit/services/166/158857880/img.gif">http://www.recruitersalesevent.nl/cxcntr/pagevisit/services/166/158857880/img.gif</a></span>
</p>
<h2 class="c3">
	<a name="h.p5qj6p33lxqw"></a><span>vacancies</span><span>2candidates
		[deprecated]</span>
</h2>
<p class="c3">
	<span>This type is used to send available vacancies to
		candidates and registering their interest</span>
</p>
<h3 class="c3">
	<a name="h.yknybnhyd0ba"></a><span>Default fields</span>
</h3>
<ol class="c29" start="13">
	<li class="c7 c3"><span class="c1">owner</span><span>&nbsp;is
			set to the owner of the candidate</span></li>
	<li class="c7 c3"><span class="c1">notes</span><span>&nbsp;is
			set to </span><span class="c1">print_r($_SERVER)</span></li>
	<li class="c7 c3"><span class="c1">subject</span><span>&nbsp;is
			set to &ldquo;</span><span class="c1">CLICK vancancy2cand
			{CampaignName} vacancy={VacancyID} {VacancyName}</span><span>&ldquo;</span></li>
	<li class="c7 c3"><span class="c1">checksum</span><span>&nbsp;is
			set to the candidate&rsquo;s </span><span class="c1">toUser.stableHash.hexadecimalDescription</span></li>
</ol>
<h3 class="c3">
	<a name="h.dnhih0un4u9b"></a><span>Links made</span>
</h3>
<p class="c3">
	<span>Aside from the default links, the note is linked to the
		candidate, the vacancy and to the company of the vacancy.</span>
</p>
<h3 class="c3">
	<a name="h.pq0spak25via"></a><span>Additional information</span>
</h3>
<p class="c3">
	<span>The </span><span class="c1">CustomerName </span><span>does
		nothing at the moment. </span><span class="c21">@deprecated</span><span>:
		Use verb </span><span class="c1">visit</span><span>&nbsp;instead</span>
</p>
<h3 class="c3">
	<a name="h.qxnubphzau5"></a><span>URI scheme</span>
</h3>
<p class="c3">
	<span class="c1">/vacancies2candidates/{AppName}/{CustomerName}/{CampaignName}/{VacancyID}/{CandidateID}/{EmailID}/{Checksum}/?url={RedirectURL}</span>
</p>
<h3 class="c3">
	<a name="h.s666arppczdj"></a><span>Example</span>
</h3>
<p class="c3">
	<span class="c9"><a class="c13"
		href="http://www.recruitersalesevent.nl/cxcntr/vacancies2candidates/services/ABBC-Holding/Test%20Campagne/441/5514/9324/3328387747/?url=http://www.google.nl">http://www.recruitersalesevent.nl/cxcntr/vacancies2candidates/services/ABBC-Holding/Test%20Campagne/441/5514/9324/3328387747/?url=http://www.google.nl</a></span>
</p>
<h2 class="c3">
	<a name="h.j6tljghmh55a"></a><span>vacancies</span><span>2contacts
		[deprecated]</span>
</h2>
<p class="c3">
	<span>This type is used to send available vacancies to contacts
		and registering their interest</span>
</p>
<h3 class="c3">
	<a name="h.yikvy7k6ogf3"></a><span>Default fields</span>
</h3>
<ol class="c29" start="17">
	<li class="c7 c3"><span class="c1">owner</span><span>&nbsp;is
			set to the owner of the contact</span></li>
	<li class="c7 c3"><span class="c1">notes</span><span>&nbsp;is
			set to </span><span class="c1">print_r($_SERVER)</span></li>
	<li class="c7 c3"><span class="c1">subject</span><span>&nbsp;is
			set to &ldquo;</span><span class="c1">CLICK vacancy2cp
			{CampaignName} vacancy={VacancyID} {VacancyName}</span><span>&ldquo;</span></li>
	<li class="c7 c3"><span class="c1">checksum</span><span>&nbsp;is
			set to the contact&rsquo;s </span><span class="c1">stableHash.hexadecimalDescription</span></li>
</ol>
<h3 class="c3">
	<a name="h.oqhacmt50ajp"></a><span>Links made</span>
</h3>
<p class="c3">
	<span>Aside from the default links, the note is linked to the
		contact, the vacancy and to the company of the vacancy.</span>
</p>
<h3 class="c3">
	<a name="h.quygddu29i8b"></a><span>Additional information</span>
</h3>
<p class="c3">
	<span>The </span><span class="c1">CustomerName </span><span>does
		nothing at the moment. </span><span class="c21">@deprecated</span><span>:
		Use verb </span><span class="c1">visit</span><span>&nbsp;instead</span>
</p>
<h3 class="c3">
	<a name="h.fr7xdz1p2je5"></a><span>URI scheme</span>
</h3>
<p class="c3">
	<span class="c1">/vacancies2contacts/{AppName}/{CustomerName}/{CampaignName}/{VacancyID}/{ContactID}/{EmailID}/{Checksum}/?url={RedirectURL}</span>
</p>
<h3 class="c3">
	<a name="h.2zzro1akma5i"></a><span>Example</span>
</h3>
<p class="c3">
	<span class="c9"><a class="c13"
		href="http://www.recruitersalesevent.nl/cxcntr/vacancies2contacts/services/ABBC-Holding/Test%20Campagne/441/5863/9324/167149111/?url=http://www.google.nl">http://www.recruitersalesevent.nl/cxcntr/vacancies2contacts/services/ABBC-Holding/Test%20Campagne/441/5863/9324/167149111/?url=http://www.google.nl</a></span>
</p>
<h2 class="c3">
	<a name="h.8ukma2vxad1o"></a><span>candidates2contacts
		[deprecated]</span>
</h2>
<p class="c3">
	<span>This type is used to send available candidates to
		contacts and registering their interest</span>
</p>
<h3 class="c3">
	<a name="h.11m2ece3vi9d"></a><span>Default fields</span>
</h3>
<ol class="c29" start="21">
	<li class="c7 c3"><span class="c1">owner</span><span>&nbsp;is
			set to the owner of the candidate</span></li>
	<li class="c7 c3"><span class="c1">notes</span><span>&nbsp;is
			set to </span><span class="c1">print_r($_SERVER)</span></li>
	<li class="c7 c3"><span class="c1">subject</span><span>&nbsp;is
			set to &ldquo;</span><span class="c1">CLICK cand2cp {CampaignName}
			cand={CandidateName}</span><span>&ldquo;</span></li>
	<li class="c7 c3"><span class="c1">checksum</span><span>&nbsp;is
			set to the candidate&rsquo;s </span><span class="c1">toUser.stableHash.hexadecimalDescription</span></li>
</ol>
<h3 class="c3">
	<a name="h.b4nqr9spkta9"></a><span>Links made</span>
</h3>
<p class="c3">
	<span>Aside from the default links, the note is linked to the
		contact, the vacancy and to the company of the vacancy.</span>
</p>
<h3 class="c3">
	<a name="h.1tjvl658inkj"></a><span>Additional information</span>
</h3>
<p class="c3">
	<span>The </span><span class="c1">CustomerName </span><span>does
		nothing at the moment. </span><span class="c21">@deprecated</span><span>:
		Use verb </span><span class="c1">visit</span><span>&nbsp;instead</span>
</p>
<h3 class="c3">
	<a name="h.p8yfahb44ndh"></a><span>URI scheme</span>
</h3>
<p class="c3">
	<span class="c1">/candidates2contacts/{AppName}/{CustomerName}/{CampaignName}/{VacancyID}/{ContactID}/{EmailID}/{Checksum}/?url={RedirectURL}</span>
</p>
<h3 class="c3">
	<a name="h.1py72lgoxcej"></a><span>Example</span>
</h3>
<p class="c3">
	<span class="c9"><a class="c13"
		href="http://www.recruitersalesevent.nl/cxcntr/candidates2contacts/services/ABBC-Holding/Test%20Campagne/5514/5863/9324/3328387747/?url=http://www.google.nl">http://www.recruitersalesevent.nl/cxcntr/candidates2contacts/services/ABBC-Holding/Test%20Campagne/5514/5863/9324/3328387747/?url=http://www.google.nl</a></span>
</p>
<h1 class="c3">
	<a name="h.g4k6oz1ofabq"></a><span>Notes linked overview</span>
</h1>
<p class="c3">
	<span>For each click, a note is created in the target Carerix
		application. This note is linked to a candidate, and/or a vacancy
		and/or a contact person. &nbsp;Here is an overview:</span>
</p>
<p class="c3 c6">
	<span></span>
</p>
<a href="#" name="98b12d381d2137a5545f86658481a146af0eac24"></a>
<a href="#" name="2"></a>
<table cellpadding="0" cellspacing="0" class="c33">
	<tbody>
		<tr class="c16">
			<td class="c18 c32"><p class="c3 c6 c12">
					<span class="c8"></span>
				</p></td>
			<td class="c10 c32"><p class="c3 c12">
					<span class="c8">export code (suggested)</span>
				</p></td>
			<td class="c20"><p class="c3 c12 c17">
					<span class="c8">Candidate</span>
				</p></td>
			<td class="c15 c32"><p class="c3 c12 c17">
					<span class="c8">Vacancy <br>Job Order
					</span>
				</p></td>
			<td class="c25 c32"><p class="c3 c12 c17">
					<span class="c8">Contact Person</span>
				</p></td>
		</tr>
		<tr class="c16">
			<td class="c18"><p class="c3 c12">
					<span class="c8">A</span>
				</p></td>
			<td class="c10"><p class="c3 c12">
					<span class="c8">(not used)</span>
				</p></td>
			<td class="c26"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
			<td class="c15"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
			<td class="c25"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
		</tr>
		<tr class="c16">
			<td class="c18"><p class="c3 c12">
					<span class="c8">B</span>
				</p></td>
			<td class="c10"><p class="c3 c12">
					<span class="c8">mailopened</span>
				</p></td>
			<td class="c26"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
			<td class="c15"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
			<td class="c25"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
		</tr>
		<tr class="c16">
			<td class="c18"><p class="c3 c12">
					<span class="c8">C</span>
				</p></td>
			<td class="c10"><p class="c3 c12">
					<span class="c8">visit</span>
				</p></td>
			<td class="c26"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
			<td class="c15"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
			<td class="c25"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
		</tr>
		<tr class="c16">
			<td class="c18"><p class="c3 c12">
					<span class="c8">D</span>
				</p></td>
			<td class="c10"><p class="c3 c12">
					<span class="c8">vacs2contacts</span>
				</p></td>
			<td class="c26"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
			<td class="c15"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
			<td class="c25"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
		</tr>
		<tr class="c16">
			<td class="c18"><p class="c3 c12">
					<span class="c8">E</span>
				</p></td>
			<td class="c10"><p class="c3 c12">
					<span class="c8">mailopened</span>
				</p></td>
			<td class="c26"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
			<td class="c15"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
			<td class="c25"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
		</tr>
		<tr class="c16">
			<td class="c18"><p class="c3 c12">
					<span class="c8">F</span>
				</p></td>
			<td class="c10"><p class="c3 c12">
					<span class="c8">cands2contacts</span>
				</p></td>
			<td class="c26"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
			<td class="c15"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
			<td class="c25"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
		</tr>
		<tr class="c16">
			<td class="c18"><p class="c3 c12">
					<span class="c8">G</span>
				</p></td>
			<td class="c10"><p class="c3 c12">
					<span class="c8">(not possible)*</span>
				</p></td>
			<td class="c26"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
			<td class="c15"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
			<td class="c25"><p class="c3 c12 c17">
					<span class="c8">0</span>
				</p></td>
		</tr>
		<tr class="c16">
			<td class="c18"><p class="c3 c12">
					<span class="c8">H</span>
				</p></td>
			<td class="c10"><p class="c3 c12">
					<span class="c8">vacs2contacts</span>
				</p></td>
			<td class="c26"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
			<td class="c15"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
			<td class="c25"><p class="c3 c12 c17">
					<span class="c8">1</span>
				</p></td>
		</tr>
	</tbody>
</table>
<p class="c3 c6">
	<span></span>
</p>
<p class="c3 c30">
	<span class="c27">1 = note is linked to object of category in
		column heading</span>
</p>
<p class="c3 c30">
	<span class="c27">0 = note is not linked</span>
</p>
<p class="c3 c30">
	<span class="c27">* Carerix automatically links a contact when
		a vacancy is linked, therefore<br>situations G leads to
		situation H
	</span>
</p>
<h1 class="c3 c4">
	<a name="h.geibl2k8f0jq"></a>
</h1>
<hr style="page-break-before: always; display: none;">
<h1 class="c3 c4">
	<a name="h.gpq0r81yzejr"></a>
</h1>
<h1 class="c3">
	<a name="h.hkluvl8mtbyd"></a><span>Installation</span>
</h1>
<p class="c3">
	<span>To install the application, all that is required is to
		put the sourcecode in a separate folder on the desired host. Then,
		find the </span><span class="c1">passLookup</span><span>&nbsp;function
		in the file </span><span class="c1">configure.php</span><span>&nbsp;and
		add a case to the switch such that the method will return the XML
		password for your app. This password can be found through </span><span
		class="c1">settings &gt; XML Interface &gt; xmlPassword</span><span>.</span>
</p>
<p class="c3">
	<span>Other than that, you only need to make sure the folder </span><span
		class="c1">db</span><span>&nbsp;is globally read- and
		writeable (</span><span class="c1">chmod 777</span><span>).</span>
</p>
<h2 class="c3">
	<a name="h.j5a7snmrzgzn"></a><span>Requirements</span>
</h2>
<p class="c3">
	<span>To make this all work, the following software components
		are used</span>
</p>
<ol class="c29" start="1">
	<li class="c7 c3"><span>PHP 5.2 (but it should work from
			PHP5.1 and onwards): </span><span class="c9"><a class="c13"
			href="http://php.net">http://php.net</a></span></li>
	<li class="c7 c3"><span>Limonade library for routing: </span><span
		class="c9"><a class="c13"
			href="http://limonade-php.github.com/">http://limonade-php.github.com/</a></span></li>
	<li class="c7 c3"><span>Sqlite for the stand alone DB </span><span
		class="c35">file</span><span>: </span><span class="c9"><a
			class="c13" href="http://www.sqlite.org/">http://www.sqlite.org/</a></span></li>
	<li class="c7 c3"><span>PDO for the DB interaction: </span><span
		class="c9"><a class="c13"
			href="http://php.net/manual/en/book.pdo.php">http://php.net/manual/en/book.pdo.php</a></span><span>&nbsp;(standard
			since PHP5.0)</span></li>
</ol>
<p class="c3">
	<span>The Limonade library makes it much easier to process the
		various URL structures needed for different countings.</span>
</p>
<p class="c3 c6">
	<span></span>
</p>
<p class="c3">
	<span>And that&rsquo;s all folks!</span>
</p>
<hr style="page-break-before: always; display: none;">
<h1 class="c3 c4">
	<a name="h.dofovvvu4fe3"></a>
</h1>
<h1 class="c3">
	<a name="h.pat4q9rlqyu2"></a><span>TODO</span>
</h1>
<ol class="c34" start="1">
	<li class="c3 c7"><span>Google analytics?</span><sup><a
			href="#cmnt1" name="cmnt_ref1">[a]</a></sup><span>&nbsp;on hold</span></li>
	<li class="c7 c3"><span>Build dashboard?</span><sup><a
			href="#cmnt2" name="cmnt_ref2">[b]</a></sup><span>&nbsp;on hold</span></li>
</ol>
<div>
	<p class="c3 c6 c30">
		<span></span>
	</p>
</div>
<div class="c36">
	<p class="c3 c12">
		<a href="#cmnt_ref1" name="cmnt1">[a]</a><span>jasperstafleu:</span>
	</p>
	<p class="c3 c12">
		<span>OK, but what to do with it?</span>
	</p>
</div>
<div class="c36">
	<p class="c3 c12">
		<a href="#cmnt_ref2" name="cmnt2">[b]</a><span>jasperstafleu:</span>
	</p>
	<p class="c3 c12">
		<span>Is a lot of work, and whether it supplies more useful
			info than a weldesigned carerix report remains to be seen...</span>
	</p>
</div>
