<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Role;

use App\Entity\Users;
use App\Entity\Posts;
use App\Entity\Comments;
use App\Entity\Votes;
use App\Entity\Tags;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user1 = new Users();

        $user1->setPseudo("ben")
            ->setPassword("ben")
            ->setLastName("ben")
            ->setFirstName("penelle")
            ->setEmail("ben@test.com")
            ->setReputation(0)
            ->setRole(Role::Member)
            ->setBirthDate(new \DateTime("2019-11-15"));
                        
        $manager->persist($user1);

        $user2 = new Users();
        $user2->setPseudo("boris")
            ->setPassword("boris")
            ->setLastName("boris")
            ->setFirstName("verahegen")
            ->setEmail("boris@test.com")
            ->setReputation(15)
            ->setRole(Role::Admin)
            ->setBirthDate(new \DateTime("2019-11-15"));
                        
        $manager->persist($user2);

        $user3 = new Users();
        $user3->setPseudo("alain")
            ->setPassword("alain")
            ->setLastName("alain")
            ->setFirstName("silovy")
            ->setEmail("alain@test.com")
            ->setReputation(0)
            ->setRole(Role::Member)
            ->setBirthDate(new \DateTime("2019-11-15"));
                        
        $manager->persist($user3);

        $user4 = new Users();
        $user4->setPseudo("bruno")
            ->setPassword("bruno")
            ->setLastName("bruno")
            ->setFirstName("lacroix")
            ->setEmail("bruno@test.com")
            ->setReputation(7)
            ->setRole(Role::Member)
            ->setBirthDate(new \DateTime("2019-11-15"));
                        
        $manager->persist($user4);

        $user5 = new Users();
        $user5->setPseudo("admin")
            ->setPassword("admin")
            ->setLastName("admin")
            ->setFirstName("administration")
            ->setEmail("admin@test.com")
            ->setReputation(30)
            ->setRole(Role::Admin)
            ->setBirthDate(new \DateTime("2019-11-15"));
                        
        $manager->persist($user5);
        /****************************************** tous mes posts *********************************************/

        $post1 = new Posts();

        $post1->setTitle("What does 'initialization' exactly mean?")
            ->setBody("My csapp book says that if global and static variables are initialized, than they are contained in .data section in ELF relocatable object file.
            So my question is that if some `foo.c` code contains 
            ```
            int a;
            int main()
            {
                a = 3;
            }`
            ```
            and `example.c` contains,
            ```
            int b = 3;
            int main()
            {
            ...
            }
            ```
            is it only `b` that considered to be initialized? In other words, does initialization mean declaration and definition in same line?")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user1);
                        
        $manager->persist($post1);

        $post2 = new Posts();

        $post2->setBody("It means exactly what it says. Initialized static storage duration objects will have their init values set before the main function is called. Not initialized will be zeroed. The second part of the statement is actually implementation dependant,  and implementation has the full freedom of the way it will be archived. 
            When you declare the variable without the keyword `extern`  you always define it as well")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user2)
            ->setParent($post1);
                        
        $manager->persist($post2);

        $post3 = new Posts();

        $post3->setBody("Both are considered initialized
        ------------------------------------
        They get [zero initialized][1] or constant initalized (in short: if the right hand side is a compile time constant expression).
        > If permitted, Constant initialization takes place first (see Constant
        > initialization for the list of those situations). In practice,
        > constant initialization is usually performed at compile time, and
        > pre-calculated object representations are stored as part of the
        > program image. If the compiler doesn't do that, it still has to
        > guarantee that this initialization happens before any dynamic
        > initialization.
        > 
        > For all other non-local static and thread-local variables, Zero
        > initialization takes place. In practice, variables that are going to
        > be zero-initialized are placed in the .bss segment of the program
        > image, which occupies no space on disk, and is zeroed out by the OS
        > when loading the program.
        To sum up, if the implementation cannot constant initialize it, then it must first zero initialize and then initialize it before any dynamic initialization happends.
          [1]: https://en.cppreference.com/w/cpp/language/zero_initialization
        ")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user3)
            ->setParent($post1);
                        
        $manager->persist($post3);

        $post4 = new Posts();

        $post4->setTitle("How do I escape characters in an Angular date pipe?")
            ->setBody("I have an Angular date variable `today` that I'm using the [date pipe][1] on, like so:
            {{today | date:'LLLL d'}}
        > February 13
        However, I would like to make it appear like this:
        > 13 days so far in February
        When I try a naive approach to this, I get this result:
            {{today | date:'d days so far in LLLL'}}
        > 13 13PM201818 18o fPMr in February
        This is because, for instance `d` refers to the day.
        How can I escape these characters in an Angular date pipe? I tried `\d` and such, but the result did not change with the added backslashes.
          [1]: https://angular.io/api/common/DatePipe")
            ->setTimestamp( new \DateTime("2019-11-15"))
            ->setUser($user1);
                        
        $manager->persist($post4);

        $post5 = new Posts();

        $post5->setBody("How about this:
            {{today | date:'d \'days so far in\' LLLL'}}
        Anything inside single quotes is ignored. Just don't forget to escape them.")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user1)
            ->setParent($post4);
                        
        $manager->persist($post5);

        $post6 = new Posts();

        $post6->setBody("Then only other alternative to stringing multiple pipes together as suggested by RichMcCluskey would be to create a custom pipe that calls through to momentjs format with the passed in date. Then you could use the same syntax including escape sequence that momentjs supports.
        Something like this could work, it is not an exhaustive solution in that it does not deal with localization at all and there is no error handling code or tests.
            import { Inject, Pipe, PipeTransform } from '@angular/core';
            @Pipe({ name: 'momentDate', pure: true })
            export class MomentDatePipe implements PipeTransform {
                transform(value: any, pattern: string): string {
                    if (!value)
                        return '';
                    return moment(value).format(pattern);
                }
            }
        And then the calling code:
            {{today | momentDate:'d [days so far in] LLLL'}}
        For all the format specifiers see the [documentation for format][1]. 
        Keep in mind you do have to import `momentjs` either as an import statement, have it imported in your cli config file, or reference the library from the root HTML page (like index.html).
          [1]: http://momentjs.com/docs/#/displaying/format/")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user3)
            ->setParent($post4);
                        
        $manager->persist($post6);

        $post7 = new Posts();

        $post7->setBody("As far as I know this is not possible with the Angular date pipe at the time of this answer. One alternative is to use multiple date pipes like so:
        {{today | date:'d'}} days so far in {{today | date:'LLLL'}}
    EDIT:
    After posting this I tried @Gh0sT 's solution and it worked, so I guess there is a way to use one date pipe.")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user2)
            ->setParent($post4);
                        
        $manager->persist($post7);

        $post8 = new Posts();

        $post8->setTitle("Q1")
            ->setBody("Q1")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user5);
                        
        $manager->persist($post8);

        $post9 = new Posts();

        $post9->setBody("R1")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user1)
            ->setParent($post8);
                        
        $manager->persist($post9);

        $post10 = new Posts();

        $post10->setBody("R2")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user2)
            ->setParent($post8);
                        
        $manager->persist($post10);

        $post11 = new Posts();

        $post11->setBody("R3")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user3)
            ->setParent($post8);
                        
        $manager->persist($post11);

        $post12 = new Posts();

        $post12->setTitle("Q2")
            ->setBody("Q2")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user4);
                        
        $manager->persist($post12);

        $post13 = new Posts();

        $post13->setBody("R4")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user5)
            ->setParent($post12);
                        
        $manager->persist($post13);

        $post14 = new Posts();

        $post14->setTitle("Q3")
            ->setBody("Q3")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user1);
                        
        $manager->persist($post14);

        $post15 = new Posts();

        $post15->setBody("R5")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user5)
            ->setParent($post14);
                        
        $manager->persist($post15);

        $post16 = new Posts();

        $post16->setBody("R6")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user3)
            ->setParent($post14);
                        
        $manager->persist($post16);

        $post17 = new Posts();

        $post17->setTitle("Q4")
            ->setBody("Q4")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user2);
                        
        $manager->persist($post17);

        $post18 = new Posts();

        $post18->setBody("R7")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user3)
            ->setParent($post17);
                        
        $manager->persist($post18);

        $post19 = new Posts();

        $post19->setTitle("Q5")
            ->setBody("Q8")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user4);
                        
        $manager->persist($post19);

        $post20 = new Posts();

        $post20->setBody("R8")
            ->setTimestamp(new \DateTime("2019-11-22"))
            ->setUser($user3)
            ->setParent($post19);
                        
        $manager->persist($post20);

        $post4->setAccepted($post5);
        $manager->persist($post4);


        $comment1 = new Comments();

        $comment1->setBody('Global ""uninitialized"" variables typically end up in a ""bss"" segment, which will be initialized to zero.')
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user1)
            ->setPost($post1);
                        
        $manager->persist($comment1);

        $comment2 = new Comments();

        $comment2->setBody("[stackoverflow.com/questions/1169858/…]() This might help")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user2)
            ->setPost($post1);
                        
        $manager->persist($comment2);

        $comment3 = new Comments();

        $comment3->setBody("Verified that this works! Pretty cool")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user2)
            ->setPost($post6);
                        
        $manager->persist($comment3);

        $comment4 = new Comments();

        $comment4->setBody('For me it works with double quotes. `{{today | date:""d \days so far in\ LLLL""}}`')
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user3)
            ->setPost($post7);
                        
        $manager->persist($comment4);

        $comment5 = new Comments();

        $comment5->setBody("This does not provide an answer to the question. Once you have sufficient reputation you will be able to comment on any post; instead, provide answers that don't require clarification from the asker.")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user2)
            ->setPost($post6);
                        
        $manager->persist($comment5);

        $comment6 = new Comments();

        $comment6->setBody("Duplicate of [xxx](yyy). Please stop!")
            ->setTimestamp(new \DateTime("2019-11-15"))
            ->setUser($user1)
            ->setPost($post6);
                        
        $manager->persist($comment6);


        $vote1 = new Votes();

        $vote1->setUpDown(1)
            ->setPost($post1)
            ->setUser($user5);
                        
        $manager->persist($vote1);

        $vote2 = new Votes();

        $vote2->setUpDown(1)
            ->setPost($post2)
            ->setUser($user3);
                        
        $manager->persist($vote2);

        $vote3 = new Votes();

        $vote3->setUpDown(-1)
            ->setPost($post1)
            ->setUser($user2);
                        
        $manager->persist($vote3);

        $vote4 = new Votes();

        $vote4->setUpDown(-1)
            ->setPost($post1)
            ->setUser($user3);
                        
        $manager->persist($vote4);

        $vote5 = new Votes();

        $vote5->setUpDown(1)
            ->setPost($post3)
            ->setUser($user2);
                        
        $manager->persist($vote1);

        $tag1 = new Tags();
        $tag1->setName("angular");
        $manager->persist($tag1);

        $tag2 = new Tags();
        $tag2->setName("typescript");
        $manager->persist($tag2);

        $tag3 = new Tags();
        $tag3->setName("csharp");
        $manager->persist($tag3);

        $tag4 = new Tags();
        $tag4->setName("EntityFramework Core");
        $manager->persist($tag4);

        $tag5 = new Tags();
        $tag5->setName("dotnet core");
        $manager->persist($tag5);

        $tag6 = new Tags();
        $tag6->setName("mysql");
        $manager->persist($tag6);

        $tag7 = new Tags();
        $tag7->setName("java");
        $manager->persist($tag7);
       
                        
        $manager->flush();
    }
}
