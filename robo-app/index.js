import 'react-native-gesture-handler';
import { registerRootComponent } from 'expo';

import App from './src/App';
// import { AppRegistry } from 'react-native';

// registerRootComponent calls AppRegistry.registerComponent('main', () => App);
// It also ensures that whether you load the app in Expo Go or in a native build,
// the environment is set up appropriately

// AppRegistry.registerComponent('App', () => App);
registerRootComponent(App);
