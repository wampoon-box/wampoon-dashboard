# WAMPoon Dashboard

This is a web-based dashboard for the Portable Windows Apache MySQL PHP stack. This dashboard provides a centralized interface to manage and monitor your local development environment.

## Features

- **Quick Links**: Automatically generates links to all projects in your `htdocs` directory.
- **System Information**: Displays versions of Apache, MySQL, PHP, and WAMPoon.
- **Navigation**: Easy access to phpMyAdmin and PHP configuration.

## Installation

1. Place the `wampoon-dashboard` directory in your WAMPoon installation:
   - For production: `[WAMPoon_INSTALL_DIR]/apps/wampoon-dashboard/`
   - For development: `[WAMPoon_INSTALL_DIR]/htdocs/wampoon-dashboard/`

2. Access the dashboard through your web browser:
   - Production and development: `localhost/wampoon-dashboard/`

### Configuration

The dashboard automatically detects your environment and configures itself:

- **htdocs Path**: Automatically determined based on installation location
- **Server Hostname**: Defaults to `http://localhost`
- **Apache Port**: Configurable in `includes/config.php` (default: 80)

>NOTE: You might need to adjust the port number if your web server is using port other than 80 (default). In that case, the port number must be specified in `includes/config.php`.

## Development

### For Developers

If you want to contribute to the project or modify the dashboard for your needs:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/wampoon-box/wampoon-dashboard.git
   cd wampoon-dashboard
   ```

2. **Set up your development environment:**
   - Ensure you have a local web server with PHP support (Apache, Nginx, or built-in PHP server)
   - Place the cloned repository in your web server's document root or configure a virtual host

3. **Development setup:**
   ```bash
   # For quick testing with PHP's built-in server
   php -S localhost:8000
   ```
   
## Reporting Issues

If you encounter any bugs or have feature requests, please report them on the project's [GitHub repository](https://github.com/wampoon-box/wampoon-dashboard.git)

When reporting issues, please include:

- Your operating system and version.
- WAMPoon version information.
- Steps to reproduce the issue.
- Expected vs actual behavior.
- Any error messages or screenshots.
  
## License

This project is licensed under the [MIT license](LICENSE).
