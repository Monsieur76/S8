### Contributing
If you've written a new formatter, adapted ToDo to a new locale, or fixed a bug, your contribution is welcome!

Before proposing a pull request, check the following:

* Your code should follow the PSR-4 coding standard. Run make sniff to check that the coding standards are followed, and run make fix to fix inconsistencies.
* Unit tests should still pass after your patch. Run the tests on your dev server (with make test) or check the continuous integration status for your pull request.
* As much as possible, add unit tests for your code.
 This makes diffs easier to read, and facilitates core review.
* If you add new formatters, please include documentation for it in the README. Don't forget to add a line about new formatters in the  Doc to help.
* If your new formatters are specific to a certain locale, document them in the formatters list instead and in the Doc.
* Avoid changing existing sets of data.
* Speed is important in all usages. Make sure your code is optimized to generate thousands of  items in no time, without consuming too much memory or CPU.
* If you commit a new feature, be prepared to help maintaining it. 
* Watch the project on GitHub, and please comment on issues or PRs regarding the feature you contributed.

Thank you for your contribution! ToDo wouldn't be so great without you.