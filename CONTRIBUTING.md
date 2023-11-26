# Contributing to Laravel DDD Template

We warmly welcome contributions to the Laravel DDD Template project. Your input is crucial in making this project better and more effective for everyone. Please take a moment to read through these guidelines before submitting your contributions.

## How to Contribute

### Reporting Issues

If you find a bug or have a suggestion for improvement, please first check the issue tracker to see if it has already been reported.
If not, feel free to open a new issue. When creating an issue, please provide:

- A clear and descriptive title.
- A detailed description of the issue or suggestion.
- Steps to reproduce the bug, if applicable.
- Any relevant code snippets or links.

### Coding Standards

- Follow the coding style and best practices already in use in the project.
- Ensure your code is well-documented and includes comments where necessary.
- Write clean, maintainable, and efficient code.

### Procedure

Before any pull request is merged into the main branch, it must pass several Continuous Integration (CI) checks. These checks ensure that the code meets the project's quality standards and does not introduce any regressions. Here are the key CI checks in place:

1. **Run Laravel Pint**
   - **_Purpose_**: Ensures that the code adheres to the coding standards established for the Laravel framework. It automatically formats the code for consistency and readability.
2. **Run Rector**
   - **_Purpose_**: Performs automated code refactoring to improve code quality and modernize the codebase, ensuring adherence to the latest PHP best practices.
3. **Run PHPStan**
   - **_Purpose_**: Conducts static analysis of the code to detect potential errors, bugs, and inconsistencies. This step helps maintain a high level of code reliability and robustness.
4. **Run Tests**
   - **_Unit Tests_**: Validates individual units of code for correctness.
   - **_Integration Tests_**: Ensures that different parts of the application work together as expected.

Contributors are encouraged to run these checks locally before submitting their pull requests. This not only speeds up the review process but also helps in maintaining the overall health of the codebase.

Pull requests that fail to pass these checks will need to be revised. Detailed results of the CI checks can be viewed directly on the pull request page in GitHub, providing insights into any issues that need to be addressed.

### Community Guidelines

- Be respectful and considerate in your interactions with other contributors.
- Provide constructive feedback when reviewing others' contributions.
- Stay open to different ideas and viewpoints.

### Participating in Discussions

For questions, suggestions, or general discussions about the Laravel DDD Template project, please use the [Discussions](https://github.com/orgs/LaraCraftHub/discussions) section in the GitHub repository. This platform is an excellent place for community engagement, where you can:

- Ask Questions: If you're unsure about how something works or need help with your contributions, feel free to ask.
- Share Ideas: We welcome new ideas or suggestions on improving the project.
- Seek Feedback: Post your thoughts or proposals to get feedback from other contributors and maintainers.
- Engage with the Community: Participate in ongoing discussions or start new ones, contributing to the collaborative environment of the project.

Remember to be respectful and considerate in discussions, fostering a positive and welcoming community for everyone involved in the project.

**Thank you for contributing to the Laravel DDD Template project!**
