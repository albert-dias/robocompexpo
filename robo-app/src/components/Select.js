import React from 'react';
import { SafeAreaView, StyleSheet } from 'react-native';
import Option2 from '../../src/components/Option2.js';
import { GroupControl } from '../pages/Login/style';

export default Select = (props) => {
    const { options, onPress, selected } = props;

    return (
        <SafeAreaView style={styles.itemsContainer}>
            <GroupControl style={styles.items}>
                {options.map(item => (
                    <Option2
                        key={String(item.id)}
                        urlIcon={String(item.url_icon)}
                        value={item.id}
                        name={item.name}
                        onPress={() => onPress(item.id)}
                        isSelected={selected.includes(item.id)}
                    />
                ))}
            </GroupControl>
        </SafeAreaView>
    );
};

const styles = StyleSheet.create({
    itemsContainer: {
        width: '100%',
        padding: 20,
    },
    items: {
        flexDirection: 'row',
        flexWrap: 'wrap',
        justifyContent: 'space-between',
        padding: 5,
    },
});