# Documentation

## Structure

- **Character** The main entry point for the users. For example : *Regdar*
- **Game** It serves as a reference for the characters that would be created. For example : *Dungeons & Dragons*
- **Linked Item** It's the link between a playableItem and a character.
- **Playable Item** It's the link between an item and a game.
- **Item** It will be the main element of a character. For example : *Iron Sword in the category equipment*
- **Category** It will contain items. For example : *Equipment or Objects*
- **Component** It's the abstract version of the item. For example : *Iron Sword*
- **Parameter** A type of value. For example : *string, number or even boolean*
- **LinkedItemField** It's a field for an linked item. For example : *personal note*
- **PlayableItemField** It's a field for a playable item. For example : *description, quantity or damage*
- **Item Field** It's the field default to all items, not component. For example : *For the item Iron Sword in the category Equipment, the damage*
- **Component Field** It's the field default to all components and so items from this component. For example : *For the component Iron Sword, the description*

## Use cases

### GM case

1. A user creates a game, like *Dungeons & Dragons*.
2. In this game, he creates a category *Equipment*.
3. Then, he creates a component *Iron Sword* and linked it to the category *Equipment*, creating an item.
4. Then, he creates a Component field *description* with the parameter *string*. He fills the description with *A sword made of iron.*
5. Then, he creates a Item field *damage* with the parameter *int*. He fills it with *10*.

### Player case

1. A user creates a character, like *Regdar*. He linked it to the game *Dungeons & Dragons*.
2. He adds the category *Equipment* from the game.
3. He adds the item *Iron Sword* with the description *A sword made of iron.* and the damage *10*
4. He updates the description for *A great sword made of iron.*, that doesn't modify the original description.
5. He adds a new linked item field for him *history*, and he fills it with *Redgar had this sword since young.*

## Rules

1. A character can only have a game.
2. A game can't have the same category multiple times.
3. A component can't have the same category multiple times.
4. A character can have the same item multiple times.
5. A component created by the creator of a game can be added by all characters of the game, whereas a component created by a player can only be add in the character he uses.
