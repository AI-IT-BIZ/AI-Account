<!DOCTYPE html>

<?php
	function inject_sample($file) {
		$dirfile = dirname(__FILE__) . '/'. $file;
		if(empty($dirfile) || !file_exists($dirfile)) { 
			printf('Cannot open sample code: %s', $dirfile);
			return false;
		}
		$fh = fopen($dirfile, 'r')
			or printf('Cannot open sample code');
		$contents = fread($fh, filesize($dirfile));
		echo htmlentities($contents);
		fclose($fh);
	}
?>

<html>
  <head>
    <title>Documentation</title>

    <meta charset='utf-8'>
	<link rel="stylesheet" href="highlight/styles/github.css">


  <style>


  </style>

  </head>
  <body>

      <header id='intro'>
        <h1 class='introduction'>
			Sample Code for JasperReports PHP Client
        </h1>
        <p>
			JasperSoft Corporation
		  <br>
		  <br>
			Code highlighting for this page provided by <a href="http://softwaremaniacs.org/soft/highlight/en/">highlight.js</a>, written by Ivan Sagalaev (<a href="highlight/LICENSE">license</a>/<a href="highlight/AUTHORS.en.txt">authors</a>).
        </p>
      </header>

	<nav>
	<h1> Table of Contents </h1>
	  <ul id='#toc'>
	    <li><a href="#about_class">About the class</a></li>
		<li><a href="#repository_service">Repository Service</a></li>
		<li><a href="#resource_service">Resource Service</a></li>
		<li><a href="#report_service">Report Service</a></li>
		<li><a href="#user_service">User Service</a></li>
		<li><a href="#attribute_service">Attribute Service</a></li>
		<li><a href="#organization_service">Organization Service</a></li>
		<li><a href="#role_service">Role Service</a></li>
		<li><a href="#jobsummary_service">JobSummary Service</a></li>
		<li><a href="#job_service">Job Service</a></li>
		<li><a href="#permission_service">Permission Service</a></li>
	  </ul>
	</nav>

	<section class='about'>
		<article id='about_class'>
			<h3> About the class </h3>
			<p>
			   The JasperReports PHP Client is a wrapper for the JasperReports Web Services API that accesses and represents data offered
			   by the JasperReports Server Web Services. Data can be requested from the server and stored in objectes that are modeled after the
			   objects offered by the server. Objects can be modified on the client side, and then "posted" back to the server.
			   The functions in the class are modeled after their actions and the HTTP verbs that correspond with them. This abstraction allows people
			   familiar with RESTful APIs to recognize the intentions and implementations of features, while people unfamiliar with RESTful APIs are still
			   not burdened with learning all the details behind interacting with the API, building XML requests, and digesting the HTTP responses.
			   Use of this wrapper is intented to allow users to focus on their logic and implementation rather than detailed communications with a server.
			</p>
		</article>
	</section>

	<section class='examples'>

<!-- skeleton
	<article>
		<h3>  </h3>
		<p>

		</p>
		<pre>
		<code>
			<?php inject_sample(''); ?>
		</code>
		</pre>
	</article>
end of skeleton -->


	<h2 id='prep'> Preparing the class </h2>

	<article>
		<h3> Invoking the client </h3>
		<p>
		In order to utilize this class you must first invoke the client object. Once the client object is initilized you can begin using its functions. In all the following examples
		it will be assumed the following code is at the beginning of the file.
		</p>

		<pre>
		<code>
			<?php inject_sample('code/client_invokation.txt'); ?>
		</code>
		</pre>
	</article>

	<h2 id='repository_service'> Repository Service </h2>

	<article id="repository_get">
		<h3> Obtaining all resources in the repository </h3>
		<p>
		The getRepository() function returns an array of objects correlating to the request. See code for the arguments for this function. The objects returned are easily
		manipulated and have in them all the data returned by the server. When echoed, they will output an XML representation of themselves.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/repository_get.txt'); ?>
		</code>
		</pre>
	</article>

	<h2 id='resource_service'> Resource Service </h2>

	<article id="resource_get">
		<h3> Getting a Resource </h3>
		<p>
		To obtain an object for a 'resource' on the server. It is necessary to provide the path to the getResource function.
		If you would like to get a resource while supplying information to the input controls, you must define IC_GET_QUERY_DATA
		with the datasource you would like to query. Furthermore, you must supply the name of the parameter and the values you wish
		to set on the select field. See the example below to understand how you can select multiple objects from one multi-select
		input control.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/resource_get.txt'); ?>
		</code>
		</pre>
	</article>
	
	<article id="resource_delete">
		<h3> Deleting a Resource </h3>
		<p>
		To delete a resource, simply pass the URI that corresponds to the resource you wish to delete to the deleteResource() function.
		A boolean value is returned that represents the success of the call. Only certain resources can be deleted through the API. Please refer to the 
		Web Services Guide PDF to understand which resources are capable of being deleted.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/resource_delete.txt'); ?>
		</code>
		</pre>
	</article>
	
	<article id="resource_put">
		<h3> Uploading a new Resource </h3>
		<p>
		To upload a resource you must create a ResourceDescriptor object that corresponds to the resource you are uploading. You must also provide the
		path you wish to upload to (not the same as the URI string). If you are uploading a file with the resource (i.e: an image) you can pass the full
		file path to the 3rd argument of the function. <br /><br />
		If there is no file to attach to the resource, simply omit the third argument.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/resource_put.txt'); ?>
		</code>
		</pre>
	</article>	
	
	<article id="resource_post">
		<h3> Updating an existing Resource </h3>
		<p>
		To update a resource, retrieve its existing ResourceDescriptor using the <a href="#resource_get">getResource()</a> function.
		Make changes to the object you retrieved that reflect the changes you wish to make using the get/set methods for the
		ResourceDescriptor object. If you are changing a file as well, supply the full path to the file you wish to upload as the third argument.
		The first argument must be the URI that matches the resource you wish to change. This may be different than the URI path you used when creating the
		resource using the PUT method however.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/resource_post.txt'); ?>
		</code>
		</pre>
	</article>	

	<h2 id='report_service'> Report Service </h2>

	<article id="run_report_html">
		<h3> Retrieving an HTML report </h3>
		<p>
		The following code will request the AllAccounts sample report in HTML format. Since the data is HTML, we can simply echo it and the report will be presented in a webpage.
		You can do many things with the binary data, including <a href="#run_report_file">offering the file to be downloaded</a> or storing it to a file.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/run_report_html.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="report_options">
		<h3> Viewing Report Options </h3>
		<p>
		You can view the different stored options for your reports that have input controls using this function. Simply provide the URI of the report that has options, and an array of objects representing each report option will be returned.
		The example below shows you how to request all the ReportOptions objects, iterate through them and print the Labels of each of them. There is more information available in these objects (uri and id), and can be retrieved with get methods as well.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/report_options.txt'); ?>
		</code>
		</pre>
	</article>
	
	<article id="create_report_options">
		<h3> Creating Report Options </h3>
		<p>
		To create a new report option, follow the example below. Note that when you are creating the $reportOptions argument for the function, the values for the options must be wrapped in an array, even if there is only one element. The example
		below shows how to create a new report that selects two options for Country_multi_select and three options for Cascading_state_multi_select.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/create_report_options.txt'); ?>
		</code>
		</pre>
	</article>

        <article id="delete_report_options">
                <h3> Deleting Report Options </h3>
                <p>
		To delete report options, you must retrieve the URI for the report containing the options, and provide the label for the option setting. If your report options has whitespace in the label, currently this function may not handle it well. Instead use the <a href="#resource_delete"> deleteResource()</a> function to delete the Report Option. 
		The example below will remove the report options created in the example above.
                </p>
                <pre>
                <code>
                        <?php inject_sample('code/delete_report_options.txt'); ?>
                </code>
                </pre>
        </article>

	
	<article id="input_controls">
		<h3> Viewing Input Controls </h3>
		<p>
		Reports that have input controls allow you to request the input controls, their values, and their default selection status through the API. Using the example below, you can see all the possible values for each key listed below the key itself.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/input_controls.txt'); ?>
		</code>
		</pre>
	</article>
	
	<article id="run_report_ic">
		<h3> Running a report with input controls </h3>
		<p>
		The following example displays how a report can be ran with various input controls set.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/run_report_ic.txt'); ?>
		</code>
		</pre>
	</article>
	
	<article id="run_report_file">
		<h3> Offering a report for download </h3>
		<p>
		By offering the proper headers before anything else is sent by the script, we can serve binary data to a browser as a download.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/run_report_file.txt'); ?>
		</code>
		</pre>
	</article>
	
	<h2 id='user_service'> User Service </h2>

	<article id="user_get">
		<h3> Getting a user </h3>
		<p>
		Using the getUsers() function it is possible to request User objects that can be manipulated and provided to other functions. In the following example, the user 'CaliforniaUser'
		is requested from the server. This function will always return an array of zero or more elements.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/user_get.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="user_post">
		<h3> Modifying a user </h3>
		<p>
		To modify a user, one must first request the user object of the user they wish to modify. Then it is possible to manipulate the object with its instance methods, and "post" it back to the server
		any changes made of the local copy of the object should be reflected on the server once posted. If data is modified that cannot be changed, or false data is provided (such as an invalid email) then
		the package will throw an Exception that reports the HTTP status code received. Currently it is required to manually set the password before posting a user object.
		<br />
		Note that you must provide the $old_username argument to the post_user function when updating a user's login name. The API must have the old username to find the previous user to update its information.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/user_post.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="user_delete">
		<h3> Deleting a user </h3>
		<p>
		One must provide a user object to be deleted to the deleteUser function. The following example illustrates how to delete multiple users with only a list of usernames.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/user_delete.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="user_put">
		<h3> Creating a new user </h3>
		<p>
		To create a new user, one must first construct a User object. Once the user object is populated with the appropriate amount of information it can be "put" to the server.
		Take note that this function can also accept multiple user objects stored in an array. If you need to create many users at once, it can all be done with one request.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/user_put.txt'); ?>
		</code>
		</pre>
	</article>

	<h2 id='attribute_service'> Attribute Service </h2>

	<article id="attribute_new">
		<h3> Adding an attribute </h3>
		<p>
		To add attributes, one must first create Attribute objects by providing the name and value of the attributes to the constructor. Then one can bundle the attributes in an array
		to pass as an argument. Or one may provide one single attribute as the second argument if it is only needed to add one attribute.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/attribute_new.txt'); ?>
		</code>
		</pre>
	</article>

	<h2 id='organization_service'> Organization Service </h2>

	<article id="organization_put">
		<h3> Creating a new Organization </h3>
		<p>
		Creating a new organization requires constructing a new Organization object and sending it to the server with the PUT verb.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/organization_put.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="organization_get">
		<h3> Getting an Organization </h3>
		<p>
		To get an organization, we can provide the getOrganization function with either a string or an Organization object. The __toString method for an Organization object will return a
		string representation of the Organization's ID. Thus, passing either will work properly.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/organization_get.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="organization_delete">
		<h3> Deleting an Organization </h3>
		<p>
		An organization may be deleted by providing the Organization Object that correlates to the organization that is to be deleted. This can be retrieved as shown below by using the
		getOrganization() method.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/organization_delete.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="organization_post">
		<h3> Modifying an Organization </h3>
		<p>
		Modifying an organization is done in a similar fashion to <a href="#user_post">modifying a user</a>. The organization object needs to be obtained with the <a href="#organization_get">getOrganization method</a>
		and then modify it with the get/set methods, and "post" it back to the server, as shown below.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/organization_post.txt'); ?>
		</code>
		</pre>
	</article>

	<h2 id='role_service'> Role Service </h2>

	<article id="role_get">
		<h3> Getting a Role </h3>
		<p>
		It is possible to request roles and their data from web services. It is also possible to limit the results by a search term if looking for a specific role. The following example
		shows you how to request the role object. Using print_r you can see all the values stored in the object.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/role_get.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="role_put">
		<h3> Creating a Role </h3>
		<p>
		Creating a role is very similar to creating other objects on the server, such as <a href="#user_put">creating a user</a>. First, craft the object to be added. Then use the putRole method
		to add the object to the server.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/role_put.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="role_delete">
		<h3> Deleting a Role </h3>
		<p>
		Deleting a role requires you to provide the Role object taken from the <a href="#role_get">getRoles() method</a>. If a role belongs to an organization, it must be provided in the getRoles method
		to retrieve the correct Role.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/role_delete.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="role_post">
		<h3> Modifying a Role </h3>
		<p>
		One can really only change a Role's name. You may also change its externallyDefined status, but that is not recommended. When you change the name of
		the Role, it is necessary that you provide the old name of the Role so it can be properly referenced to be altered.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/role_post.txt'); ?>
		</code>
		</pre>
	</article>

	<h2 id="jobsummary_service"> JobSummary Service </h2>

	<article id="jobsummary_get">
		<h3> Listing report scheduling jobs </h3>
		<p>
		Using the new 'jobs' service offered in JasperReports v4.7 we it is possible to query for jobs in three ways. By providing no arguments to the function one can request all
		of the currently scheduled jobs. By providing a URI one can request all jobs assigned to a specific report. By providing the name (label) of a report, one can request a 
		single report. The function will always return an array with 0 or more elements.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/jobsummary_get.txt'); ?>
		</code>
		</pre>
	</article>
	
	<h2 id="job_service"> Job Service </h2>
	
	<article id="job_delete">
		<h3> Deleting a schedule job </h3>
		<p>
		Jobs can be deleted using this function. This function is best combined with the <a href="#jobsummary_get">getJobs() function</a>
		The function below uses getJobs to request all jobs matching the title 'jobName' on the server. If we get one result, we know that
		our results are not ambigous and in fact correlate to the job we requested. Proceeding we can delete the job by supplying its ID (from the getId function)
		to the deleteJob function. A boolean value is returned to help determine if the operation was successful. Similar to all other functions
		an exception will be thrown if the server rejects the request.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/job_delete.txt'); ?>
		</code>
		</pre>
	</article>	

	<article id="job_pause">
		<h3> Pausing a schedule job </h3>
		<p>
		Jobs can be paused using the pauseJob function. The only argument for this function accepts either a single job ID as an integer,
		 an array of job IDs; or, if no argument is provided all jobs will be paused.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/job_pause.txt'); ?>
		</code>
		</pre>
	</article>

	<article id="job_resume">
		<h3> Resuming a schedule job </h3>
		<p>
		It is possible to resume a job that has been previously paused. The only argument for this function is a form of the ID's of the jobs to be resumed
		this value can be either null (resume all jobs), an integer/string referring to the job's ID you wish to use (This can be retrieved using the JobSummary service
		as shown below) or an array of int/strings that refer to the job IDs.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/job_resume.txt'); ?>
		</code>
		</pre>
	</article>
	
	<article id="job_post">
		<h3> Updating a scheduled job </h3>
		<p>
		To update a scheduled job, simply request the old job object from the server, modify it, and then use the postJob() function to reupload it to the server to be updated.
		The Job class utilizes properties and arrays to manage its data, which is different from the other objects which use only properties. This means you will not use get/set methods
		to alter the data in a Job object, but rather set the properties as if they were variables. If a property refers to a nested element of the job class, use array functions to manipulate
		the arrays.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/job_post.txt'); ?>
		</code>
		</pre>
	</article>
	
	<article id="job_put">
		<h3> Creating a new Job </h3>
		<p>
		Jobs can be created from scratch. However, the way these objects interact is different than the other objects
		in the package. The values of the Job class are varied, and organized through associative arrays. In the example below you can 
		see how the values are set for the various flags of the Job object. If a section requires more than one element of the same type
		(i.e: adding multiple toAddresses to send an alert to) it must be added using the PHP array functions. See below how this is done
		</p>
		<pre>
		<code>
			<?php inject_sample('code/job_put.txt'); ?>
		</code>
		</pre>
	</article>	
	
	<h2 id="permission_service"> Permission Service </h2>
	
	<article id="permission_get">
		<h3> Viewing the permissions of a resource </h3>
		<p>
		One can retrieve all the non-inherited permissions on a resource by providing the URI to the getPermissions() function. An array of zero or more items is returned and the array contains
		Permission objects that represent all the permissions the server returned. In the following example it is necessary to determine whether the PermissionRecipient is a User or Role object by using the 
		instanceof function. This way we can use the object to display the information it may contain.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/permission_get.txt'); ?>
		</code>
		</pre>
	</article>
	
	<article id="permission_delete">
		<h3> Deleting a permission of a resource </h3>
		<p>
		Using the deletePermission() function, you can remove a permission that is set. You must first request the existing permissions using the <a href="#permission_get">getPermissions() function</a>. 
		Then send the object of the permission you wish to be deleted to this function and it will be done. When a permission is erased, the role or user's permissions default back to the inhereted 
		permissions.
		The example below will remove all User-typed permissions set on the dashboards folder.
		</p>
		<pre>
		<code>
			<?php inject_sample('code/permission_delete.txt'); ?>
		</code>
		</pre>
	</article>

        <article id="permission_update">
                <h3> Updating a permission of a resource </h3>
                <p>
                Using the updatePermissions() function, you can alter or change the permissions of a resource. You must first request the existing permissions using the <a href="#permission_get">getPermissions() function</a>.
                Then create a new Permission object, and add it to the current permissions. Once you issue the updatePermissions command, the permissions will be updated. The example below lets user 'joeuser' become an administer over the /images/JRLogo resource.
                </p>
                <pre>
                <code>
                        <?php inject_sample('code/permission_update.txt'); ?>
                </code>
                </pre>
        </article>


    </section>

	<footer style="float: right;">
		<a href="#intro">back to top</a>
	</footer>

  <script src="highlight/highlight.pack.js"></script>
  <script type="text/javascript">
	hljs.tabReplace = '  ';
	hljs.initHighlightingOnLoad();
  </script>
  </body>
</html>
