import React from 'react';
import { TouchableOpacity, Image, StyleSheet, Text, View } from 'react-native';
import { FontAwesome5 } from '@expo/vector-icons';
import theme from '../global/styles/theme';

const Option2 = props => {
    const {onPress, isSelected, value, urlIcon, name} = props;
  
    return (
      <TouchableOpacity onPress={onPress}>
        <View style={styles.item}>
          <Image
            style={[styles.icon, isSelected ? styles.active : styles.inactive]}
            source={{
              uri: urlIcon,
            }}
          />
          {isSelected && (
            <FontAwesome5
              name='check'
              style={styles.selectedIcon}
              color={theme.colors.orange}
              size={32}
            />
          )}
        </View>
        <Text style={styles.iconText}>{name}</Text>
      </TouchableOpacity>
    );
  };
  
  const styles = StyleSheet.create({
    icon: {
      width: 70,
      height: 70,
      marginVertical: 10,
      marginLeft: 3,
      borderRadius: 50,
    },
    active: {
      opacity: 0.7,
      borderWidth: 3,
      borderColor: theme.colors.orange,
    },
    inactive: {
      borderWidth: 3,
      borderColor: 'transparent',
    },
    iconText: {
      textAlign: 'center',
      flexWrap: 'wrap',
      width: 75,
    },
    selectedIcon: {
      position: 'absolute',
    },
    item: {
      justifyContent: 'center',
      alignItems: 'center',
    },
  });
  
  export default Option2;