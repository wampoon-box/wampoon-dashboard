# Wampoon Dashboard

This is a web-based dashboard for [Wampoon](https://wampoon-box.github.io/): the portable stack for running Apache, MySQL, and PHP stack locally. This dashboard provides a centralized interface to manage and monitor your local development environment.

## Features

- **Quick Links**: Automatically generates links to all projects in your `htdocs` directory.
- **System Information**: Displays versions of Apache, MySQL, PHP.
- **Navigation**: Easy access to phpMyAdmin and PHP configuration.

### Configuration

The dashboard automatically detects your environment and configures itself:

- **htdocs Path**: Automatically determined based on installation location
- **Server Hostname**: Defaults to `http://localhost`
- **Apache Port**: Configurable in `includes/config.php` (default: 80)

## Contributing


**Prerequisites:** PHP 8.4+ and a web server (Apache or PHP's built-in server)

**1. Quick Setup:**
```bash
# Fork the repository on GitHub, then clone your fork
git clone https://github.com/your-username/wampoon-dashboard.git
cd wampoon-dashboard

```

2. Start Apache using WampoonControl

3. Access the dashboard through your web browser: `localhost/wampoon-dashboard/`


### Making Changes

1. Create a new branch for your feature or bugfix
2. Make your changes and test thoroughly
3. Ensure your code follows the existing style and conventions
4. Submit a pull request with a clear description of your changes

### What You Can Contribute

- Bug fixes and improvements
- New features for WAMP server management
- UI/UX enhancements
- Documentation improvements
- Performance optimizations
   
## Reporting Issues

If you encounter any bugs or have feature requests, please report them on the project's [GitHub repository](https://github.com/wampoon-box/wampoon-dashboard.git)

When reporting issues, please include:

- Your operating system and version.
- Wampoon version information.
- Steps to reproduce the issue.
- Expected vs actual behavior.
- Any error messages or screenshots.
  
## License

This project is licensed under the [MIT license](LICENSE).
