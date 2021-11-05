import { StyleSheet } from 'react-native';
import theme from '../../global/styles/theme';

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: theme.colors.gray,
    justifyContent: 'flex-start',
    flexDirection: 'column',
    padding: 50,
  },
  scrollView: {
    backgroundColor: theme.colors.gray,
    marginHorizontal: 0,
  },
  containerAvatar: {
    alignItems: 'center',
  },
  containerName: {
    justifyContent: 'flex-start',
    alignItems: 'flex-start',
  },
  div: {
    backgroundColor: 'black',
    width: '100%',
    height: 1,
  },
  divText: {
    alignItems: 'flex-end',
  },
  divwhitebtn: {
    backgroundColor: theme.colors.gray,
    width: '50%',
    height: 1,
    padding: 10,
  },
  divwhite: {
    backgroundColor: theme.colors.gray,
    width: '80%',
    height: 1,
    padding: 20,
  },
  text: {
    justifyContent: 'flex-start',
    textAlign: 'left',
    fontSize: 20,
    padding: 10,
  },
  textInput: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 0,
  },
  btn: {
    padding: 3,
    backgroundColor: theme.colors.slider,
  },
});

export default styles;
