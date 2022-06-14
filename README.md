# Sentimenti; label texts easily

![Sentimenti Screenshot](/sentimenti_screen.png)

Sentimenti allows you to quickly label texts on a 9-likert scale. Simply click one of the buttons and the text score is automatically saved to the data CSV.

As Sentimenti saves the texts to your local data file, PHP is required to use this application. Fortunately, [XAMPP](https://www.apachefriends.org/) can be used to easily enable this functionality. 

Before you can use Sentimenti, you will have to upload your data file, ```data.csv```, to the root of the repository. Make sure that the first column is called <strong>sentiment</strong> and the second column is called <strong>text</strong>. It is important to note that the app expects the unscored texts to have a default sentiment score of ```99```. Of course, you could always edit ```index.php``` to fit your needs. The names and positions of other columns are not relevant. In the end, your data CSV should somewhat look like this:
| sentiment     | text          | ...           |
| ------------- | ------------- | ------------- |
| 99            | text1         | ...           |
| 99            | text2         | ...           |
| ...           | ...           | ...           |

Now, to start labelling your texts:
1. Start your local PHP server (e.g. using XAMPP)
2. Navigate to Sentimenti in your browser
3. Label the texts

Sentimenti automatically saves each newly given score, so feel free to close and continue the process whenever it is convenient.

Good luck!