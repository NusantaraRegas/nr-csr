Based on a comprehensive analysis of the codebase, the project is **NOT** configured to automatically redirect to HTTPS. It is already set up to run on HTTP.

### **Analysis Findings**
1.  **Environment Configuration**: The `.env` file explicitly sets `APP_URL=http://10.10.10.121`, which tells the application to generate HTTP links.
2.  **No Code-Level Enforcement**:
    *   `App\Providers\AppServiceProvider.php` does **not** contain `URL::forceScheme('https')`.
    *   There is no middleware (e.g., `ForceHttps`) registered in `app/Http/Kernel.php` that would force a secure connection.
    *   `config/session.php` does not enforce secure cookies (defaults to `false` since `SESSION_SECURE_COOKIE` is not set).
3.  **No Server-Level Enforcement**: No `.htaccess` files were found in the project root or `public/` directory that would handle redirects at the server level.

### **Conclusion**
No changes are required to disable HTTPS redirection because it is not enabled. The project is already configured to use HTTP as requested.

### **Next Steps**
Since no changes are needed, I will conclude this task. If you are experiencing redirects, they might be caused by:
*   Browser caching (try clearing cache or using Incognito mode).
*   External network configuration (load balancer, proxy, or firewall rules) which are outside this codebase.

Do you want me to perform any other checks?