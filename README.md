<h1>UECS3294 Advanced Web Application Development</h1>

<h4>FYP</h4>
<table style="border-collapse: collapse;">
  <tr>
    <th>Name</th>
    <th>Student ID</th>
  </tr>
  <tr>
    <td>
      <ul>
      
        <li>Low Wei Heng</li>
       
      </ul>
    </td>
    <td>
      <ul style="list-style-type: none; margin: 0; padding: 0;">
      
        
        <li>2004604</li>
        
      </ul>
    </td>
  </tr>
</table>

<h2>Assignment title: PLATFORM FOR INDEPENDENT CONTRACTOR COMMUNITIES</h2>

<p>This assigment project Student Result Management System is based on the open-source project developed by <a href="https://phpgurukul.com/php-projects-free-downloads/#google_vignette">Anuj Kumar</a></p><br />
<p>Here is the link to the open-source project: <a href="https://phpgurukul.com/student-result-management-system/">https://phpgurukul.com/student-result-management-system/</a></p>

<h2>Guide on Running the Project</h2>
<p>Steps on Running the Cloned Repository:</p>
<ol>
  <li>Please note that when the Laravel project is pushed to github, it does not include the <code>vendor</code> folder. <code>vendor</code> folder contains all the dependencies for our project. But the dependecies needed are all listed in the <code>composer.json</code> file. Please run <pre lang="bash">composer update</pre> to regenerate the <code>vendor</code> folder and update all the dependencies to the latest version. </li>
  <li>Then we need to install all the listed dependencies into the recreated <code>vendor</code> folder by running <pre lang="bash">composer install</pre></li>
    <li>Please note that there is no <code>.env</code> file!!! When the Laravel project is pushed to github it will ignore the <code>.env</code> file. So when you clone and pull the project please rename the <code>.env.example</code> file to <code>.env</code>. After you have renamed the file and set all the credentials. Please run <pre lang="bash">php artisan key:generate</pre> to generate an application encryption key for your cloned project. </li>
</ol>

